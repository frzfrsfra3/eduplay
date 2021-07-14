tinymce.PluginManager.add('questionadd', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('questionadd', {
        text: 'Q { }',
        icon: false,
        onclick: function() {
            // Open window
            editor.windowManager.open({
                title: 'Question plugin',
                body: [
                    {type: 'textbox', name: 'maxtime', label: 'Max Time'},
                    {type: 'listbox', name: 'level', label: 'Difficulty Level',values: [
                            {text : 'Easy', value: 'easy'},
                            {text : 'Medium', value: 'medium'},
                            {text : 'Hard', value: 'hard'},
                        ]},
                    {type: 'textbox', name: 'tags', label: 'Tags'},

                ],
                onsubmit: function(e) {var st='';
                    // Insert content when the window form is submitted

                    st="\\Q  \\T:'" + e.data.maxtime+"'"+" \\D:'" + e.data.level+"'"+" \\tag:'" + e.data.tags+"' " +"<br>" +"{" +editor.selection .getContent()+" <br> } ";
                    editor.insertContent(st);
                }
            });
        }
    });



    return {
        getMetadata: function () {
            return  {
                name: "questionadd plugin",
                url: "http://exampleplugindocsurl.com"
            };
        }
    };
});
