module.exports = function (grunt) {
    //Configuration
    grunt.initConfig({

        grunticon: {
            myIcons: {
                files: [{
                    expand: true,
                    cwd: 'wp-content/themes/sogo-child/images/svg',
                    src: ['*.svg', '*.png'],
                    dest: "wp-content/themes/sogo-child/images/grunticon"
                }],
                options: {
                    enhanceSVG: true,
                    colors: {
                        color1: "#d60019",
                        color2: "#f1c40f",
                        color3: "#006fc0",
                        color4: "#00afef",
                        color5: "#0bb7d7",
                        color6: "#797979",
                        color7: "#c5c5c5",
                        color8: "#f2f2f2",
                        colorwhite: "#ffffff"
                    }
                }
            }
        }

    });

    grunt.loadNpmTasks('grunt-grunticon');

};