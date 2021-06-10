<?php
return [
	"backend" => [
	    "access" => [
            "roles" => [
                "already_exists" => "That role already exists. Please choose a different name.",
                "cant_delete_admin" => "You can not delete the Administrator role.",
                "create_error" => "There was a problem creating this role. Please try again.",
                "delete_error" => "There was a problem deleting this role. Please try again.",
                "has_users" => "You can not delete a role with associated users.",
                "needs_permission" => "You must select at least one permission for this role.",
                "not_found" => "That role does not exist.",
                "update_error" => "There was a problem updating this role. Please try again.",
            ],

            "permissions" => [
                "already_exists" => "That permission already exists. Please choose a different name.",
                "create_error" => "There was a problem creating this permission. Please try again.",
                "delete_error" => "There was a problem deleting this permission. Please try again.",
                "not_found" => "That permission does not exist.",
                "update_error" => "There was a problem updating this permission. Please try again.",
            ],

            "users" => [
                "cant_deactivate_self" => "You can not do that to yourself.",
                "cant_delete_self" => "You can not delete yourself.",
                "cant_delete_admin" => "You can not delete Admin.",
                "cant_delete_own_session" => "You can not delete your own session.",
                "cant_restore" => "This user is not deleted so it can not be restored.",
                "create_error" => "There was a problem creating this user. Please try again.",
                "delete_error" => "There was a problem deleting this user. Please try again.",
                "delete_first" => "This user must be deleted first before it can be destroyed permanently.",
                "email_error" => "That email address belongs to a different user.",
                "mark_error" => "There was a problem updating this user. Please try again.",
                "not_found" => "That user does not exist.",
                "restore_error" => "There was a problem restoring this user. Please try again.",
                "role_needed_create" => "You must choose at lease one role.",
                "role_needed" => "You must choose at least one role.",
                "session_wrong_driver" => "Your session driver must be set to database to use this feature.",
                "change_mismatch" => "That is not your old password.",
                "update_error" => "There was a problem updating this user. Please try again.",
                "update_password_error" => "There was a problem changing this users password. Please try again.",
            ],
	    ],

        "pages" => [
            "already_exists" => "That Page already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Page. Please try again.",
            "delete_error" => "There was a problem deleting this Page. Please try again.",
            "not_found" => "That Page does not exist.",
            "update_error" => "There was a problem updating this Page. Please try again.",
        ],

        "settings" => [
            "update_error" => "There was a problem updating this Settings. Please try again.",
        ],

        "menus" => [
            "already_exists" => "That Menu already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Menu. Please try again.",
            "delete_error" => "There was a problem deleting this Menu. Please try again.",
            "not_found" => "That Menu does not exist.",
            "update_error" => "There was a problem updating this Menu. Please try again.",
        ],

        "modules" => [
            "already_exists" => "That Module already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Module. Please try again.",
            "delete_error" => "There was a problem deleting this Module. Please try again.",
            "not_found" => "That Module does not exist.",
            "update_error" => "There was a problem updating this Module. Please try again.",
        ],

        "categories" => [
            "already_exists" => "That CategoriesManagement already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this CategoriesManagement. Please try again.",
            "delete_error" => "There was a problem deleting this CategoriesManagement. Please try again.",
            "not_found" => "That CategoriesManagement does not exist.",
            "update_error" => "There was a problem updating this CategoriesManagement. Please try again.",
        ],

        "products" => [
            "already_exists" => "That ProductManagement already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this ProductManagement. Please try again.",
            "delete_error" => "There was a problem deleting this ProductManagement. Please try again.",
            "not_found" => "That ProductManagement does not exist.",
            "update_error" => "There was a problem updating this ProductManagement. Please try again.",
        ],

        "vendors" => [
            "already_exists" => "That VendorManagement already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this VendorManagement. Please try again.",
            "delete_error" => "There was a problem deleting this VendorManagement. Please try again.",
            "not_found" => "That VendorManagement does not exist.",
            "update_error" => "There was a problem updating this VendorManagement. Please try again.",
        ],

        "videos" => [
            "already_exists" => "That Video already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Video. Please try again.",
            "delete_error" => "There was a problem deleting this Video. Please try again.",
            "not_found" => "That Video does not exist.",
            "update_error" => "There was a problem updating this Video. Please try again.",
        ],

        "sliders" => [
            "already_exists" => "That HomeSlider already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this HomeSlider. Please try again.",
            "delete_error" => "There was a problem deleting this HomeSlider. Please try again.",
            "not_found" => "That HomeSlider does not exist.",
            "update_error" => "There was a problem updating this HomeSlider. Please try again.",
        ],

        "subscriptions" => [
            "already_exists" => "That Subscription already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Subscription. Please try again.",
            "delete_error" => "There was a problem deleting this Subscription. Please try again.",
            "not_found" => "That Subscription does not exist.",
            "update_error" => "There was a problem updating this Subscription. Please try again.",
        ],
    ],

	"frontend" => [
	    "auth" => [
	        "confirmation" => [
                "already_confirmed" => "Your account is already confirmed.",
                "confirm" => "Confirm your account!",
                "created_confirm" => "Your account was successfully created. We have sent you an e-mail to confirm your account.",
                "created_pending" => "Your account was successfully created and is pending approval. An e-mail will be sent when your account is approved.",
                "mismatch" => "Your confirmation code does not match.",
                "not_found" => "That confirmation code does not exist.",
                "resend" => "Your account is not confirmed. Please click the confirmation link in your e-mail, or <a href=http://localhost/umami-square/www/public/account/confirm/resend/:user_id>click here</a> to resend the confirmation e-mail.",
                "success" => "Your account has been successfully confirmed!",
                "resent" => "A new confirmation e-mail has been sent to the address on file.",
            ],
	        "deactivated" => "Your account has been deactivated.",
	        "email_taken" => "That e-mail address is already taken.",
	        "password" => [
	            "change_mismatch" => "That is not your old password.",
	        ],
	        "registration_disabled" => "Registration is currently closed.",
	    ],
	],
];