# This is a simple build file for cake to compile
# all coffeescripts in the app/assets/javascripts/ folder to public/admin
{exec} = require 'child_process'
task 'build', 'Builds coffeescript sources', ->
    exec 'coffee --compile --output public/admin/ app/assets/javascripts/', (err, stdout, stderr) ->
        throw err if err
        console.log stdout + stderr
