<?php

/* @noinspection PhpUnhandledExceptionInspection */
/* phpcs:disable Generic.Files.LineLength */

declare(strict_types=1);

use Rancoud\Application\Application;
use Rancoud\Security\Security;

/* @var $data array */
?>
<footer class="footer">
    <div class="footer__container">
        <div class="footer__logo">
            <a aria-label="Home of <?php echo Security::escAttr(Application::getConfig()->get('SITE_NAME', 'blueprintUE')); ?>" href="/" title="Home of <?php echo Security::escAttr(Application::getConfig()->get('SITE_NAME', 'blueprintUE')); ?>">
                <img class="nav__logo-svg" src="/blueprintue-self-hosted_logo.png"/>
            </a>
        </div>

        <div class="footer__legals">
            <p>
                Portions of the materials used are trademarks and/or copyrighted works of Epic Games, Inc. All rights reserved by Epic. This material is not official and is not endorsed by Epic.<br />
                Unreal, Unreal Engine, the circle-U logo and the Powered by Unreal Engine logo are trademarks or registered trademarks of Epic Games, Inc. in the United States and elsewhere.
            </p>
        </div>
    </div>
</footer>