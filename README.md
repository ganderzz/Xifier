Xifier
======

ModX Code Minifier Snippet

ModX snippet that concatenates all files specified in the script attribute, and minifies code not excluded with a ! symbol. Minification at this moment removes all comments and white space in the file.
---

Example:

	<script>
		[[!Xifier? &script=`main.js` &prefix=`js/` &time=`60`]]
	</script>
	
Takes main.js and runs the minifier on it. Since no path is specified, it looks in the assets folder for the scripts. 
The prefix is the folder inside assets where the script is found, here it is in a directory called js. After 60ms the 
cache is erased, and Xifier will reload the script from main.js and reminify it.


	<script>
		[[!Xifier? &script=`!skroller.js, !flowtype.js` &prefix=`js/`]]
	</script>

Xifier will not minify scripts that start with !. This is for scripts that are already minified, but we still want the
scripts to be concatenated to eachother.
