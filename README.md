#Darkroom

Darkroom is a symfony app to manage traditional photography activities

#Install

1. run `composer.phar update` 
2. install the folowing node packages
    1. bower `npm install bower -g and npm install bower --save-dev`
    2. gulp `npm install gulp -g and npm install gulp --save-dev` 
    3. install the following gulp plugins
        * gulp-concat
        * gulp-minify-css
        * gulp-freeze
        * gulp-lightmin
        * gulp-minify
        * gulp-uglify
3. install assets with bower install
4. build the assets with `gassetic build --env=prod`