tinymce.PluginManager.add('param', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('param', {
        text: '{{ - }}',
        icon: false,
        onclick: function() { var st="{{" +editor.selection .getContent()+"}}";
            editor.insertContent(st);
            // Open window

        }
    });



    return {
        getMetadata: function () {
            return  {
                name: "param plugin",
                url: "http://exampleplugindocsurl.com"
            };
        }
    };
});