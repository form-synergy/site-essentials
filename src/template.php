<?php
namespace FormSynergy;

/**
 * FormSynergy PHP Api template.
 *
 * This template requires the FormSynergy PHP Api.
 *
 * This template will install web essentials
 * Package repository: https://github.com/form-synergy/web-essentials
 *
 * @author     Joseph G. Chamoun <formsynergy@gmail.com>
 * @copyright  2019 FormSynergy.com
 * @licence    https://github.com/form-synergy/template-essentials/blob/dev-master/LICENSE MIT
 * @package    web-essentials
 */

/**
 * This package requires the FormSynergy PHP API
 * Install via composer: composer require form-synergy/php-api
 */
require_once 'vendor/autoload.php';

/**
 * Enable session manager
 */
\FormSynergy\Session::enable();

/**
 * Import the FormSynergy class
 */
use \FormSynergy\Fs as FS;

/**
 *
 * Web Essentials Class 
 *
 * @version 1.0
 */
class Web_Essentials
{

    public static function Run($data)
    {
 
        /**
         * Load account, this action requires the profile id
         */
        $api = FS::Api()->Load($data['profileid']);

        /**
         * The domain name in question must be already
         * registered and verified with FormSynergy.
         *
         * For more details regarding domain registration
         * API documentation: https://formsynergy.com/documentation/websites/
         *
         * You can clone the verification package from Github
         * Github repository: https://github.com/form-synergy/domain-verification
         *
         * Alternatively it can be installed via composer
         * composer require form-synergy/domain-verification
         */

        /**
         * This script will create and install the following:
         * - 1) Strategy: Essentials
         * - 2) Objectives:
         *     - New contact request
         *     - Request a call back
         *     - News letter subscription
         * - 3) Modules:
         *     - Contact form
         *     - Request a call back
         *     - News letter subscription
         */

        /**
         * ! IMPORTANT: This script is meant to be loaded once, to install certain resources.
         * If you are trying to create an auto-install script that only install missing resources,
         * Checkout the Auto installer script: https://github.com/form-synergy/auto-install
         * Via composer: composer require form-synergy/auto-install
         */

        // 1) Creating the strategy.
        $api->Create('strategy')
            ->Attributes([
                'siteid' => $data['siteid'],
                'name' => 'Web Essentials',
            ])
            ->As('strategy');

        // 2) Creating modules from pre-packaged modules.
        $api->Create('modules')
            ->Attributes([
                'siteid' => $data['siteid'],
                'modid' => $api->_strategy('modid'),
                'using' => [
                    'contact-form',
                    'request-call-back',
                    'news-letter-subscription',
                ],
            ])
            ->As('packages');

        // 3) Creating the objectives.
        $api->Create('objective')
            ->Attributes([
                'siteid' => $data['siteid'],
                'modid' => $api->_strategy('modid'),
                'label' => 'Contact request',
                'properties' => [
                    'email' => [
                        'value' => 'yes',
                    ],
                ],
                'limittomodule' => $api->_packages('contact-form')['moduleid'],
                'notificationmethod' => 'email',
                'recipient' => [
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'email' => $data['email'],
                ],
            ])
            ->As('o-contact-form');

        $api->Create('objective')
            ->Attributes([
                'siteid' => $data['siteid'],
                'modid' => $api->_strategy('modid'),
                'label' => 'Request call back',
                'properties' => [
                    'mobile' => [
                        'value' => 'yes',
                    ],
                ],
                'limittomodule' => $api->_packages('request-call-back')['moduleid'],
                'notificationmethod' => 'email',
                'recipient' => [
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'email' => $data['email'],
                ],
            ])
            ->As('o-request-call-back');

        $api->Create('objective')
            ->Attributes([
                'siteid' => $siteid,
                'modid' => $api->_strategy('modid'),
                'label' => 'News letter subscription',
                'properties' => [
                    'email' => [
                        'value' => 'yes',
                    ],
                ],
                'limittomodule' => $api->_packages('news-letter-subscription')['moduleid'],
                'notificationmethod' => 'email',
                'recipient' => [
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'email' => $data['email'],
                ],
            ])
            ->As('o-news-letter-subscription');

        /**
         * To store resources and data
         **/
        FS::Store($api->_all());
    }
}


 