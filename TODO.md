# TODO

## Plan to fix path + overall errors

1. Inspect current client/server auth code paths and PHP includes (already started via reading key files).
2. Fix inconsistent frontend fetch URLs (login/register JS now use relative controller paths).
3. Fix missing safety/behavior bugs (login/register JS now stops with an error if form elements are missing).
4. Fix config file correctness (server/db/config.php no longer echoes JSON; it only initializes $pdo).
5. Make fetch/controller URLs consistent using same base (relative to auth pages).

6. Update JS include cache-busting query parameters if they break script loading.
7. Run a quick sanity check via browser devtools expectations (no runtime errors, correct network calls).

## Completed
- server/db/config.php no longer outputs JSON.
- client/js/auth/login.js and client/js/auth/registeration.js now use consistent relative controller URLs and stop on missing elements.


