# After Comment Prompts

Display a modal message/prompt to a user after they leave a post comment.

## Installation ##

__Automatically__

1. Search for After Comment Prompts in the Add New Plugin section of the WordPress admin
2. Install & Activate

__Manually__

1. Download the zip file, unzip it and upload plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

## Frequently Asked Questions ##

*How do I use this plugin?*

After installing, you can get to work by adding a custom message to display to your readers after commenting. This setting is located in the Discussion settings page.

*Can I use the modals for purposes other than comments?*

Yes! The `after_comment_prompts_get_modal( $message )` function lets you output a modal with any message. For example:

```php
add_action( 'wp_head', 'test_after_comment_prompts_get_modal' );
function test_after_comment_prompts_get_modal() {

	echo after_comment_prompts_get_modal( 'Here is my custom message!' );
}
```

## Hooks ##
`after_comment_prompts_modal_output` (filter) Modify the global markup/output

Parameters:
`$output` - string Default markup

Return: `$output` New output

`after_comment_prompts_modal_output_comments` (filter) Modify the markup/ouput for modals shown after comment submissions

Parameters:
`$output` - string Default markup;
`$comment` - object Comment that was submitted;
`$message` - string Message setting saved in under the Discussion page

Return: $output New output

`after_comment_prompts_close_modal` (filter) Change the icon used for closing modals

Parameters: None

Return: string New icon

`after_comment_prompts_before_modal_wrap` (action) Before the modal window

Parameters: None

`after_comment_prompts_after_modal_wrap` (action) After the modal window

Parameters: None

## Bugs ##
If you find an issue, let me know!

## Changelog ##

__1.0__
* Initial version