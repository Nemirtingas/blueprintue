# blueprintUE self-hosted edition

## Minimum requirements
* >= PHP 7.4
* >= MySQL 8 or >= MariaDB 10.6

## How to install?
1. copy folders `app`, `storage`, `vendor` and paste **outside** of the public folder of your server
2. copy folder `www` and paste **inside** the public folder of your server
3. copy `dump.sql` and paste file in your database
4. copy `.env.template` and paste file **outside** of the public folder of your server
5. fill values in `.env.template` file with what you need (database and email)
6. rename `.env.template` to `.env`
7. done

The `public folder` means what your http server can show you, usually it is called is `www` or `public_html`

Don't forget to add PHP permissions to read/write in folders `storage`, `www/medias` and where you have `.env` file for cache.  
You can disable cache for `.env` by removing line `$env->enableCache();` in `www/index.php`.

## What's the difference between blueprintUE and blueprintUE self-hosted edition?
blueprintUE self-hosted edition is like blueprintUE but without
* "What is it?" section on the homepage
* blog and tools section
* OAuth for Facebook, Google and Twitter
* links in footer
* contact, terms of service, privacy policy, conditions générales d’utilisation page
* blueprintUE logo replaced with an image

## Configuration explanations
### .env file
#### Database
| Parameter                      | Mandatory | Type   | Default value | Specific values             | Description                                                |
| ------------------------------ | --------- | ------ | ------------- | --------------------------- | ---------------------------------------------------------- |
| DATABASE_DRIVER                | YES       | string |               | mysql \| pgsqlite \| sqlite | database engine used                                       |
| DATABASE_HOST                  | YES       | string |               |                             | host                                                       |
| DATABASE_USER                  | YES       | string |               |                             | user                                                       |
| DATABASE_PASSWORD              | YES       | string |               |                             | password                                                   |
| DATABASE_NAME                  | YES       | string |               |                             | database name                                              |
| DATABASE_PERSISTENT_CONNECTION | NO        | bool   | false         |                             | use persistent connection for database, only for e2e tests |

#### Session
| Parameter                 | Mandatory | Type   | Default value  | Specific values       | Description                                                                     |
| ------------------------- | --------- | ------ | -------------- | --------------------- | ------------------------------------------------------------------------------- |
| SESSION_DRIVER            | NO        | string | default        | default \| database   | session driver used                                                             |
| SESSION_ENCRYPT_KEY       | NO        | string |                |                       | if empty there is no encryption                                                 |
| SESSION_GC_MAXLIFETIME    | NO        | int    | 3600 * 24      |                       | session's lifetime before deletion by garbage collector                         |
| SESSION_LIFETIME          | NO        | int    | 0              |                       | cookie's lifetime for session                                                   |
| SESSION_PATH              | NO        | string | /              |                       | cookie's path for session                                                       |
| SESSION_HTTPS             | NO        | bool   | true           |                       | session cookie will be only accessible on https                                 |
| SESSION_SAMESITE          | NO        | string | Strict         | None \| Lax \| Strict | security policies on how cookies are shared, Lax is mandatory for Twitter OAuth |
| SESSION_REMEMBER_NAME     | NO        | string | remember_token |                       | cookie's name for remember login                                                |
| SESSION_REMEMBER_LIFETIME | NO        | int    | 3600 * 24 * 30 |                       | cookie's lifetime for remember login                                            |
| SESSION_REMEMBER_PATH     | NO        | string | /              |                       | cookie's path for remember login                                                |
| SESSION_REMEMBER_HTTPS    | NO        | bool   | true           |                       | remember cookie will be only accessible on https                                |
| SESSION_REMEMBER_SAMESITE | NO        | string | Strict         | None \| Lax \| Strict | security policies on how cookies are shared, Lax is mandatory for Twitter OAuth |

#### Host
| Parameter | Mandatory | Type   | Default value  | Specific values | Description                                 |
| --------- | --------- | ------ | -------------- | --------------- | ------------------------------------------- |
| HOST      | YES       | string |                |                 | hostname (e.g. blueprintue-self-hosted.com) |
| HTTPS     | YES       | bool   |                |                 | use for detect scheme (http or https)       |

#### Site
| Parameter          | Mandatory | Type   | Default value                   | Specific values | Description                                                                         |
| ------------------ | --------- | ------ |---------------------------------| --------------- |-------------------------------------------------------------------------------------|
| SITE_NAME          | YES       | string | blueprintUE self-hosted edition |                 | name of the site, used for email/description (e.g. blueprintUE self-hosted edition) |
| SITE_BASE_TITLE    | NO        | string |                                 |                 | use for complete the title tag                                                      |
| SITE_DESCRIPTION   | NO        | string |                                 |                 | use for description tag in home page                                                |

#### Anonymous user
| Parameter    | Mandatory | Type   | Default value  | Specific values | Description                                 |
| ------------ | --------- | ------ | -------------- | --------------- | ------------------------------------------- |
| ANONYMOUS_ID | YES       | int    |                |                 | user_id for all anonymous blueprints pasted |

#### Mail
PHPMailer is used as library for sending mails.  
You can use msmtp as service docker for smtp relay and set smtp authentication inside.

| Parameter             | Mandatory | Type   | Default value                         | Specific values | Description                                         |
| --------------------- | --------- | ------ | ------------------------------------- | --------------- | --------------------------------------------------- |
| MAIL_USE_SMTP         | NO        | bool   | false                                 |                 | set PHPMailer to use SMTP                           |
| MAIL_SMTP_HOST        | NO        | string | localhost                             |                 | SMTP host                                           |
| MAIL_SMTP_PORT        | NO        | int    | 25                                    |                 | SMTP port                                           |
| MAIL_USE_SMTP_AUTH    | NO        | bool   | false                                 |                 | for SMTP authentication                             |
| MAIL_SMTP_USER        | NO        | string |                                       |                 | user for SMTP authentication                        |
| MAIL_SMTP_PASSWORD    | NO        | string |                                       |                 | password for SMTP authentication                    |
| MAIL_FROM_ADDRESS     | YES       | string |                                       |                 | email display for sending emails                    |
| MAIL_FROM_NAME        | NO        | string |                                       |                 | name display for sendings emails                    |
| MAIL_HEADER_LOGO_PATH | YES       | string | blueprintue-self-hosted_logo-full.png |                 | header image in emails (complete by HOST parameter) |

## Crons
* GET `/cron/purge_sessions/`: remove old sessions in database (if using sessions database)
* GET `/cron/purge_users_not_confirmed/`: remove users that didn't confirmed their accounts registration after 30 days
* GET `/cron/purge_deleted_blueprints/`: remove expired blueprints
* GET `/cron/set_soft_delete_anonymous_private_blueprints/`: set soft delete for anonymous private blueprints

## FAQ
### How to skip email confirmation?
It's not recommended but this how to skip email confirmation.
In `app/services/www/UserService.php` replace function `generateAndSendConfirmAccountEmail`
```php
    public static function generateAndSendConfirmAccountEmail(int $userID, string $from): bool
    {
        return true;
    }
```
In `app/services/www/UserService.php` replace function `createMemberUser`
```php
    public static function createMemberUser(string $username, string $email, string $password): array
    {
        $errorCode = '#100';

        $userModel = (new UserModel(Application::getDatabase()));
        $userInfosModel = (new UserInfosModel(Application::getDatabase()));

        $forceRollback = false;
        $userID = 0;
        try {
            /* @noinspection NullPointerExceptionInspection */
            Application::getDatabase()->startTransaction();

            $errorCode = '#200';
            $userID = $userModel->create(
                [
                    'username'     => $username,
                    'slug'         => static::slugify($username),
                    'email'        => $email,
                    'grade'        => 'member',
                    'password'     => $password,
                    'created_at'   => Helper::getNowUTCFormatted(),
                    'confirmed_at' => Helper::getNowUTCFormatted()
                ]
            );

            // @codeCoverageIgnoreStart
            /*
             * In end 2 end testing we can't arrive here because user requirements has been done before
             * For covering we have to test the function outside
             */
            if ($userID === 0) {
                throw new \Exception('User ID is nil');
            }
            // @codeCoverageIgnoreEnd

            $errorCode = '#300';
            $userInfosModel->create(['id_user' => $userID]);
            // @codeCoverageIgnoreStart
        } catch (\Exception $exception) {
            $forceRollback = true;
            /*
             * In end 2 end testing we can't arrive here because user requirements has been done before
             * For covering we have to test the function outside
             */
            return [null, $errorCode];
            // @codeCoverageIgnoreEnd
        } finally {
            if ($forceRollback) {
                /* @noinspection NullPointerExceptionInspection */
                // @codeCoverageIgnoreStart
                /*
                 * In end 2 end testing we can't arrive here because user requirements has been done before
                 * For covering we have to mock the database
                 */
                Application::getDatabase()->rollbackTransaction();
            // @codeCoverageIgnoreEnd
            } else {
                /* @noinspection NullPointerExceptionInspection */
                Application::getDatabase()->completeTransaction();
            }
        }

        return [$userID, null];
    }
```

### How to show PHP errors?
In `www/index.php` file after the `} catch (\Throwable $t) {` you can add this line
```php
$file = $rootDir . $ds . '500-' . gmdate("Y-m-d", time()) . '.txt';
@file_put_contents($file, gmdate("Y-m-d H:i:s", time()) . "\t" . $request->getMethod() . "\t" . $request->getUri() . "\t" . $t->getMessage() . "\n", FILE_APPEND);
```
It will append errors in file to avoid showing it.  
But if you really want to show it instead you can use:
```php
var_dump(gmdate("Y-m-d H:i:s", time()) . "\t" . $request->getMethod() . "\t" . $request->getUri() . "\t" . $t->getMessage() . "\n", FILE_APPEND);
```