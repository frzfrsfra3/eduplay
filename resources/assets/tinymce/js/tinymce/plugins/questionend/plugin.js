tinymce.PluginManager.add('questionend', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('questionend', {
        text: '}',
        icon: false,
        onclick: function() { var st="}";
        editor.insertContent(st);
            // Open window

        }
    });



    return {
        getMetadata: function () {
            return  {
                name: "questionend plugin",
                url: "http://exampleplugindocsurl.com"
            };
        }
    };
});
