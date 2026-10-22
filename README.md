# Cloudily project description

## 1. Overview

Cloudily is a PHP web application for uploading, organizing, previewing, searching, and sharing files and folders. It uses a MySQL database named `cloud` and is designed to run locally under XAMPP, with the project served from the web root.

The application interface is in Italian. The main workspace uses a navigation sidebar and an iframe: the outer page provides navigation, search, and creation controls, while the selected content is rendered by a PHP page inside the iframe.

## 2. User roles and access

### Registered users

Registered users can:

- Log in with a username and password.
- Create files and folders.
- Choose whether a newly created file or folder is private or shared.
- View their own private content.
- View shared files and shared folders belonging to any user.
- Search visible files and folders.
- Preview files and the contents of folders.
- Share or make private their own files and folders.
- Move files into folders and remove files from folders.
- Delete their own files and folders.

### Guest users

The login page provides an **Entra come Guest** link. Guest access stores the string `guest` in the session instead of creating a database user.

Guests can browse public/shared content, but cannot create content. The private-files and private-folders views display a registration prompt for guests.

## 3. Main user flows

### Login

1. The user opens the login page at [`admin/index.php`](./admin/index.php).
2. The user submits a username and password.
3. The application loads the matching user through a prepared SQL statement.
4. The password is checked with `password_verify`.
5. On success, the numeric user ID is stored in `$_SESSION['id']` and the user is redirected to [`index.php`](./index.php).

If the credentials do not match, the page displays either `Utente non trovato` or `Password errata`.

### Registration

1. The user opens [`admin/signup.php`](./admin/signup.php).
2. The user enters their name, surname, email, username, password, and password confirmation.
3. The application verifies that the two passwords match.
4. The password is stored using `password_hash`.
5. A new row is inserted into the `users` table.
6. The user is redirected to the login page.

### Guest access

[`admin/ceazioneGuest.php`](./admin/ceazioneGuest.php) starts the session, sets `$_SESSION['id']` to `guest`, and redirects to the main application.

### Browsing the workspace

[`index.php`](./index.php) displays the Cloudily shell:

- Home: all shared files and folders plus the current user's private items.
- Your files: files owned by the current user.
- Shared folders: folders where `condivisione = 1`.
- Shared files: files where `condivisione = 1`.
- Your folders: folders owned by the current user.

Each section is loaded into the iframe from [`home.php`](./home.php) using the `from` query parameter.

### Creating files and folders

[`aggiungi.php`](./aggiungi.php) handles both creation forms:

- `from=0` displays the file-upload form.
- Other values display the folder-creation form.

For files, the uploaded file is moved into the `files` directory and a row is added to `files`. For folders, a row is added to `cartelle`. Both forms let the user choose whether the item is shared.

### Searching

The search controls in [`js/searchbar.js`](./js/searchbar.js) load [`ricerca.php`](./ricerca.php) into the iframe. Search compares the requested text with the display name of visible files and folders.

Visibility rules are:

- Shared items are visible to all authenticated users, including guests.
- Private items are visible only when their owner ID equals `$_SESSION['id']`.

### File previews

[`anteprima.php`](./anteprima.php) opens a selected file in an iframe. Image files with `.png` or `.jpg` extensions are displayed as images in cards; other files receive a generic document icon.

[`anteprimaCartella.php`](./anteprimaCartella.php) lists the files assigned to a selected folder and provides the same file actions and preview behavior.

### File and folder actions

The action menus are configured by [`js/menu.js`](./js/menu.js).

File actions are implemented in [`menu_file/`](./menu_file/):

- [`condividi.php`](./menu_file/condividi.php): marks an owned file as shared.
- [`privatizza.php`](./menu_file/privatizza.php): marks an owned file as private.
- [`elimina.php`](./menu_file/elimina.php): deletes the physical file and its database row.
- [`spostamento.php`](./menu_file/spostamento.php): selects a folder and assigns the file to it.
- [`togli.php`](./menu_file/togli.php): removes a file from a folder.

Folder actions are implemented in [`menu_cartelle/`](./menu_cartelle/):

- [`condividi.php`](./menu_cartelle/condividi.php): marks a folder as shared.
- [`privatizza.php`](./menu_cartelle/privatizza.php): marks a folder as private.
- [`elimina.php`](./menu_cartelle/elimina.php): removes files from the folder and deletes the folder row.

## 4. Data model

The schema is defined in [`cloud.sql`](./cloud.sql).

### `users`

Stores registered accounts:

- `ID_USER`: numeric primary key.
- `username`: unique login name.
- `psw`: password hash.
- `ruolo_user`: numeric role field, currently defaulting to `1`.
- `nome`, `cognome`, `email`: profile data.

### `cartelle`

Stores folders:

- `ID_CARTELLA`: numeric primary key.
- `denominazione`: folder display name.
- `id_user`: owning user.
- `data_creazione`: creation date.
- `condivisione`: `0` for private and `1` for shared.

The owner relationship uses a foreign key to `users`. Deleting a user cascades to their folders.

### `files`

Stores uploaded files:

- `ID_FILES`: numeric primary key.
- `denominazione`: display name.
- `nome_file`: physical filename in the `files` directory.
- `id_user`: owning user.
- `id_cartella`: optional folder relationship.
- `data_creazione`: creation date.
- `condivisione`: `0` for private and `1` for shared.

The owner relationship uses a foreign key to `users`. The folder relationship is nullable; deleting a folder sets `id_cartella` to `NULL`.

## 5. Technical structure

### PHP pages

- [`index.php`](./index.php): authenticated application shell and navigation.
- [`home.php`](./home.php): home, personal, shared-file, shared-folder, and personal-folder listings.
- [`ricerca.php`](./ricerca.php): search results.
- [`aggiungi.php`](./aggiungi.php): file and folder creation.
- [`anteprima.php`](./anteprima.php): individual file preview.
- [`anteprimaCartella.php`](./anteprimaCartella.php): folder contents.

### Authentication and configuration

- [`config/config.php`](./config/config.php): starts the session and creates the MySQL connection.
- [`config/verificaLogin.php`](./config/verificaLogin.php): redirects requests without a session ID to the login page.
- [`admin/index.php`](./admin/index.php): login form and credential verification.
- [`admin/signup.php`](./admin/signup.php): registration form and account creation.
- [`admin/ceazioneGuest.php`](./admin/ceazioneGuest.php): guest-session creation.

### Client-side JavaScript

- [`js/navbar.js`](./js/navbar.js): sidebar/navigation behavior.
- [`js/searchbar.js`](./js/searchbar.js): search requests and iframe navigation.
- [`js/add_button.js`](./js/add_button.js): creation-button expansion and redirects.
- [`js/menu.js`](./js/menu.js): file and folder action-menu links.
- [`js/anteprima.js`](./js/anteprima.js): preview navigation.

### Styling and assets

- [`css/index.css`](./css/index.css): application shell and navigation styles.
- [`css/home.css`](./css/home.css): cards, listings, and action-menu styles.
- [`css/aggiungi.css`](./css/aggiungi.css): file and folder form styles.
- [`css/variables.css`](./css/variables.css): shared CSS variables and font styles.
- [`images/`](./images/): profile and navigation assets.

## 6. Session and database configuration

The connection settings are currently defined directly in [`config/config.php`](./config/config.php):

- Host: `localhost`
- Database user: `root`
- Password: empty
- Database: `cloud`

The application relies on PHP sessions. The session key `$_SESSION['id']` contains either a registered user's numeric database ID or the literal value `guest`.

## 7. Current limitations and maintenance notes

The following behaviors are visible in the current implementation:

- There is no dedicated logout endpoint in the project.
- Database credentials are hard-coded in [`config/config.php`](./config/config.php).
- Several action endpoints interpolate request values directly into SQL and should be converted to prepared statements.
- File upload validation is limited; the original filename is used as the stored filename, so collision handling, type validation, size limits, and safer filename generation should be added.
- File and folder action authorization is not consistently enforced in every endpoint.
- `anteprima.php` builds the file path from a request value and should validate that the requested file is an allowed stored file.
- The interface uses iframe navigation, which keeps the application simple but makes navigation, browser history, and error handling less consistent.
- The application currently uses English HTML language declarations in several pages even though the visible interface is Italian.
- Shared-folder listings must select `users.username` whenever the template displays the owner. This was corrected in [`home.php`](./home.php); otherwise a guest opening “Cartelle condivise” can receive an undefined array-key warning.

## 8. Local setup

1. Install XAMPP with Apache, PHP, and MySQL.
2. Place the project under the Apache document root, for example `C:\xampp\htdocs\cloud`.
3. Start Apache and MySQL from the XAMPP control panel.
4. Import [`cloud.sql`](./cloud.sql) into MySQL.
5. Ensure the application can write uploaded files to the `files` directory.
6. Open `http://localhost/cloud/`.
7. Register a user or use the guest link from the login page.

The project does not currently include an automated test suite, dependency manifest, framework configuration, or deployment configuration.
