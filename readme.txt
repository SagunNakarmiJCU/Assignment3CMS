

The plugin is based on the concept that social profiles can be registered by using a filter. Registered social profiles are then added to the customiser to allow the site owner to enter their social profile URLs.

A widget in Wp is created which will output the list of social media URLS .

The plugin is built extensibly allowing other developers to add, edit and remove social profiles, as well as easily altering the markup of the widget output. All this can be done without modifying the actual plugin code itself, through its extensible features.
1. To add any social media platform add $profiles array by providing a parameter with name of the social media platform.
2. Customizer settings can be modified from within the function register_social_customizer_settings by passing in the parameter $wp_customize
