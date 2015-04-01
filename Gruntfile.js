/**
 * Created by nextlevelshit on 26.03.15.
 */
module.exports = function(grunt){

    "use strict";

    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    //grunt.loadNpmTasks('grunt-livereload');

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        htmlhint: {
            build: {
                options: {
                    'tag-pair': true,
                    'tagname-lowercase': true,
                    'attr-lowercase': true,
                    'attr-value-double-quotes': true,
                    'doctype-first': true,
                    'spec-char-escape': true,
                    'id-unique': true,
                    'head-script-disabled': true,
                    'style-disabled': true
                },
                src: ['index.html']
            }
        },

        watch: {
            html: {
                files: ['index.html'],
                //tasks: ['htmlhint'],
                options: {
                    livereload: true
                }
            },

            js: {
                files: ['assets/js/base.js'],
                tasks: ['uglify'],
                options: {
                    livereload: true
                }
            },

            css: {
                files: ['assets/sass/**/*.scss'],
                tasks: ['buildcss'],
                options: {
                    livereload: true
                }
            }
        },

        uglify: {
            build: {
                files: {
                    'build/js/base.min.js': ['assets/js/base.js']
                }
            }
        },

        cssc: {
            build: {
                options: {
                    consolidateViaDeclarations: true,
                    consolidateViaSelectors:    true,
                    consolidateMediaQueries:    true
                },
                files: {
                    'build/css/master.css': 'build/css/master.css'
                }
            }
        },

        cssmin: {
            build: {
                src: 'build/css/master.css',
                dest: 'build/css/master.css'
            }
        },

        sass: {
            build: {
                files: {
                    'build/css/master.css': 'assets/sass/master.scss'
                }
            }
        }//,
        //
        //livereload: {
        //    options: {
        //        base: 'public'
        //    },
        //    files: ['build/**/*', 'app/**/*']
        //}
    });

    grunt.registerTask('default', ['watch']);
    grunt.registerTask('buildcss',  ['sass', 'cssc', 'cssmin']);

};