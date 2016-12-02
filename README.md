# Milestones

Display GitHub milestones on your blog!

## Usage

Look up creating a [personal API token](https://github.com/blog/1509-personal-api-tokens) for GitHub. Insert this token
into the appropriate field on the Milestones settings page.

Then use the `milestones` shortcode like so:

```
[milestones user="netrivet" repository="prophoto-issues"]
```

Voilà! You will have milestones sorted by due date with their issues grouped underneath.

## Customizing

Checkout `view/layout.php` for an example of rendering milestones. The view has a single `$data` variable
that is the response from the GitHub API. It is a collection of milestones strait from the API, only they
have been augmented to have an `issues` key that is all issues belonging to that milestone.

There are two filters available for overriding the default CSS as well as the template:

### milestones_template

This filter can be used to return the path to a different view file that will be loaded
with the `$data` variable:

```php
add_filter('milestones_template', function ($template) {
    return '/path/to/something/different.php';
});
```

### milestones_list_milestones_css

This filter lets you replace the CSS loaded for styling milestones:

```php
add_filter('milestones_list_milestones_css', function ($url) {
    return 'http://url/to/other.css';
});
```

## Todo

* Maybe some fancier defaults
