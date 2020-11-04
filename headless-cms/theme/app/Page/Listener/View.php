<?php

namespace App\Page\Listener;

use App\Account\Model\Account;
use App\Page\Model\Page as PageModel;
use App\Account\Model\Account as AccountModel;

class View {

    public static $postType = 'page';

    public static function init() {
        // hook into the save action
        add_action('wp', self::class.'::onView', 9, 0 );
    }

    public static function onView() {

        try {
            // Retrieve the global wp object
            global $wp_query;
            // Check that we are viewing this post and that we are NOT in admin
            if (!$wp_query->is_singular || $wp_query->is_admin || $wp_query->post->post_type != static::$postType) { return false; }
            // Retrieve the loaded campaign
            $loaded_page = PageModel::load($wp_query->post->ID);
            // Retrieve the authorisation rules
            $authorised = $loaded_page->getField('security_authorised');
            $redirection = $loaded_page->getField('security_redirect');
            // If there are no redirection rules
            if (!$redirection) { return false; }
            // The allowed flags
            $allowGuest = 0;
            $allowUser = 0;
            // If authorised tags were retrieved
            if ($authorised && is_array($authorised)) {
                // Loop through each of the authorised tags
                foreach ($authorised as $k => $termObj) {
                    // Populate flags based on terms slug
                    if ($termObj->slug === 'account') {
                        $allowUser = 1;
                    } elseif ($termObj->slug === 'guest') {
                        $allowGuest = 1;
                    }
                }
            }
            // Retrieve the current user login
            $accountID = storage_get('account/login/user');
            // Determine if we should redirect out of this page
            if (!$allowGuest && !$accountID) {
                // Throw a user exception
                throw new \Exception('User not active');
            } elseif (!$allowUser && $accountID) {
                // Throw a user exception
                throw new \Exception('User not active');
            } elseif (!$allowUser && !$allowGuest) {
                // Throw a user exception
                throw new \Exception('User not active');
            } elseif ($allowUser && !$allowGuest) {
                // Retrieve the account object
                $account = Account::findFromStorage();
                // If the account is not active
                if ($account->getField('user_status') !== 'ACTIVE') {
                    // Throw a user exception
                    throw new \Exception('User not active');
                }
            }
        } catch (\Exception $e) {
            // Redirect to the designation page
            wp_redirect($redirection);
        }
    }

}