# MaciloveBlogSourceCode

Source code of our own blog platform <a href="http://macilove.com" target="_blank">macilove.com</a>, written in PHP, hosted on Nginx server. MIT License.<br/>
<img src="http://pleeq.com/github/macilove.jpg"><br/>

For any other information contact us at <a href="http://pleeq.com" target="_blank">pleeq.com</a>

Note: files that we provide have much more functions that described it all been used in our macilove.com, but right now we haven't time to describe them all. Maybe in the future we'll add more commentaries. 

Right now we'll focus on editor and content page. For information, macilove.com have this hierarchy: index / content
where index is a list of all articles and content is one concrete article. 

# Editor features
* Realtime preview.
* Autosave.
* Formatting tags (they was made like stackoverflow.com formating tags).
* Drag'n'drop images to textarea to add them in your text (image will be load and when you save article will saved to image folder).
* First row of textarea is a title of the article.
* Second row is subtitle.

Text saved with tags to database 
pros: you have flexebility to change css/html as you want for every format element in the saved text. 
cons: you need to "decode" text from database to show the result html page.


# How to install
1. Upload all files from Root folder to your server.
2. You need to set up your MySQL server.
3. Open MySQL folder. Open "articles.rtf". Create table.
2. Change passwords in config.inc.php
4. Configure Nginx server by following /Nginx server configuration files/macilove.com file.
You need to check all filepathes.

# How to write articles
1. Open http://example.com/backdoor.php and enter your pass to install admin cookies. Withou it you can't open. editor. Without such cookies editor will redirect you to index page.
2. Open http://example.com/editor/ and enter test article. Article title and subtitle will be detected automatically. Don't forget to enter unique URL. News "source" is optional.
3. Drag and drop images direcly to the editor textfield.
4. When article is ready click Save, then Publish.

Article always have main "front" image you can see.

When you done, save your text (Save button). And when you ready to publish new article push publish button.
From this moment article will be available in the index / content file. 

# Index and content files
index.php in root folder.
content.php in the news folder.

Index is a list of all articles (first screenshot). You can use it as is, or you can delete all code that related to "old" database.
You also need to add your database name and ect. 
Same thing with content.php
Check all paths and it's permissions twice, I thinks this could be the most trouble.


