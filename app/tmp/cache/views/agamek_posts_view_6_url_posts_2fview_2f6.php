<!--cachetime:1400662626--><?php
			App::uses('PostsController', 'Controller');
			
				$request = unserialize(base64_decode('TzoxMToiQ2FrZVJlcXVlc3QiOjk6e3M6NjoicGFyYW1zIjthOjY6e3M6NjoicGx1Z2luIjtOO3M6MTA6ImNvbnRyb2xsZXIiO3M6NToicG9zdHMiO3M6NjoiYWN0aW9uIjtzOjQ6InZpZXciO3M6NToibmFtZWQiO2E6MDp7fXM6NDoicGFzcyI7YToxOntpOjA7czoxOiI2Ijt9czo2OiJtb2RlbHMiO2E6Njp7czo0OiJQb3N0IjthOjI6e3M6NjoicGx1Z2luIjtOO3M6OToiY2xhc3NOYW1lIjtzOjQ6IlBvc3QiO31zOjQ6IkdhbWUiO2E6Mjp7czo2OiJwbHVnaW4iO047czo5OiJjbGFzc05hbWUiO3M6NDoiR2FtZSI7fXM6NDoiVXNlciI7YToyOntzOjY6InBsdWdpbiI7TjtzOjk6ImNsYXNzTmFtZSI7czo0OiJVc2VyIjt9czo3OiJQcm9maWxlIjthOjI6e3M6NjoicGx1Z2luIjtOO3M6OToiY2xhc3NOYW1lIjtzOjc6IlByb2ZpbGUiO31zOjc6IkFydGljbGUiO2E6Mjp7czo2OiJwbHVnaW4iO047czo5OiJjbGFzc05hbWUiO3M6NzoiQXJ0aWNsZSI7fXM6NzoiQ29tbWVudCI7YToyOntzOjY6InBsdWdpbiI7TjtzOjk6ImNsYXNzTmFtZSI7czo3OiJDb21tZW50Ijt9fX1zOjQ6ImRhdGEiO2E6MDp7fXM6NToicXVlcnkiO2E6MTp7czozOiJ1cmwiO3M6MTI6InBvc3RzL3ZpZXcvNiI7fXM6MzoidXJsIjtzOjEyOiJwb3N0cy92aWV3LzYiO3M6NDoiYmFzZSI7czo3OiIvQWdhbWVrIjtzOjc6IndlYnJvb3QiO3M6ODoiL0FnYW1lay8iO3M6NDoiaGVyZSI7czoyMDoiL0FnYW1lay9wb3N0cy92aWV3LzYiO3M6MTM6IgAqAF9kZXRlY3RvcnMiO2E6MTE6e3M6MzoiZ2V0IjthOjI6e3M6MzoiZW52IjtzOjE0OiJSRVFVRVNUX01FVEhPRCI7czo1OiJ2YWx1ZSI7czozOiJHRVQiO31zOjQ6InBvc3QiO2E6Mjp7czozOiJlbnYiO3M6MTQ6IlJFUVVFU1RfTUVUSE9EIjtzOjU6InZhbHVlIjtzOjQ6IlBPU1QiO31zOjM6InB1dCI7YToyOntzOjM6ImVudiI7czoxNDoiUkVRVUVTVF9NRVRIT0QiO3M6NToidmFsdWUiO3M6MzoiUFVUIjt9czo2OiJkZWxldGUiO2E6Mjp7czozOiJlbnYiO3M6MTQ6IlJFUVVFU1RfTUVUSE9EIjtzOjU6InZhbHVlIjtzOjY6IkRFTEVURSI7fXM6NDoiaGVhZCI7YToyOntzOjM6ImVudiI7czoxNDoiUkVRVUVTVF9NRVRIT0QiO3M6NToidmFsdWUiO3M6NDoiSEVBRCI7fXM6Nzoib3B0aW9ucyI7YToyOntzOjM6ImVudiI7czoxNDoiUkVRVUVTVF9NRVRIT0QiO3M6NToidmFsdWUiO3M6NzoiT1BUSU9OUyI7fXM6Mzoic3NsIjthOjI6e3M6MzoiZW52IjtzOjU6IkhUVFBTIjtzOjU6InZhbHVlIjtpOjE7fXM6NDoiYWpheCI7YToyOntzOjM6ImVudiI7czoyMToiSFRUUF9YX1JFUVVFU1RFRF9XSVRIIjtzOjU6InZhbHVlIjtzOjE0OiJYTUxIdHRwUmVxdWVzdCI7fXM6NToiZmxhc2giO2E6Mjp7czozOiJlbnYiO3M6MTU6IkhUVFBfVVNFUl9BR0VOVCI7czo3OiJwYXR0ZXJuIjtzOjI2OiIvXihTaG9ja3dhdmV8QWRvYmUpIEZsYXNoLyI7fXM6NjoibW9iaWxlIjthOjI6e3M6MzoiZW52IjtzOjE1OiJIVFRQX1VTRVJfQUdFTlQiO3M6Nzoib3B0aW9ucyI7YToyNjp7aTowO3M6NzoiQW5kcm9pZCI7aToxO3M6NzoiQXZhbnRHbyI7aToyO3M6MTA6IkJsYWNrQmVycnkiO2k6MztzOjY6IkRvQ29NbyI7aTo0O3M6NjoiRmVubmVjIjtpOjU7czo0OiJpUG9kIjtpOjY7czo2OiJpUGhvbmUiO2k6NztzOjQ6ImlQYWQiO2k6ODtzOjQ6IkoyTUUiO2k6OTtzOjQ6Ik1JRFAiO2k6MTA7czo4OiJOZXRGcm9udCI7aToxMTtzOjU6Ik5va2lhIjtpOjEyO3M6MTA6Ik9wZXJhIE1pbmkiO2k6MTM7czoxMDoiT3BlcmEgTW9iaSI7aToxNDtzOjY6IlBhbG1PUyI7aToxNTtzOjEwOiJQYWxtU291cmNlIjtpOjE2O3M6OToicG9ydGFsbW1tIjtpOjE3O3M6NzoiUGx1Y2tlciI7aToxODtzOjE0OiJSZXF3aXJlbGVzc1dlYiI7aToxOTtzOjEyOiJTb255RXJpY3Nzb24iO2k6MjA7czo3OiJTeW1iaWFuIjtpOjIxO3M6MTE6IlVQXC5Ccm93c2VyIjtpOjIyO3M6NToid2ViT1MiO2k6MjM7czoxMDoiV2luZG93cyBDRSI7aToyNDtzOjE2OiJXaW5kb3dzIFBob25lIE9TIjtpOjI1O3M6NToiWGlpbm8iO319czo5OiJyZXF1ZXN0ZWQiO2E6Mjp7czo1OiJwYXJhbSI7czo5OiJyZXF1ZXN0ZWQiO3M6NToidmFsdWUiO2k6MTt9fXM6OToiACoAX2lucHV0IjtzOjA6IiI7fQ=='));
				$response->type('text/html');
				$controller = new PostsController($request, $response);
				$controller->plugin = $this->plugin = '';
				$controller->helpers = $this->helpers = unserialize(base64_decode('YTo1OntpOjA7czo0OiJGb3JtIjtpOjE7czo0OiJIdG1sIjtpOjI7czo3OiJTZXNzaW9uIjtpOjM7czo3OiJDYXB0Y2hhIjtpOjQ7czo1OiJDYWNoZSI7fQ=='));
				$controller->layout = $this->layout = 'default';
				$controller->theme = $this->theme = '';
				$controller->viewVars = unserialize(base64_decode('YTo0OntzOjQ6InBvc3QiO2E6Mzp7czo0OiJQb3N0IjthOjM6e3M6MjoiaWQiO3M6MToiNiI7czo1OiJ0aXRsZSI7czo0OiJUZXN0IjtzOjQ6ImJvZHkiO3M6MjQ6IkJJVEUgSElISUhJSElISUhJSEkgQklURSI7fXM6NDoiVXNlciI7YTo1OntzOjI6ImlkIjtzOjI6Ijc0IjtzOjg6InVzZXJuYW1lIjtzOjc6IlJvbGxpbmciO3M6NDoiUG9zdCI7YToxOntpOjA7YTo2OntzOjI6ImlkIjtzOjE6IjYiO3M6NToidGl0bGUiO3M6NDoiVGVzdCI7czo0OiJib2R5IjtzOjI0OiJCSVRFIEhJSElISUhJSElISUhJIEJJVEUiO3M6NzoiY3JlYXRlZCI7czoxOToiMjAxNC0wNS0yMSAxMDoyOTo0NyI7czo4OiJtb2RpZmllZCI7czoxOToiMjAxNC0wNS0yMSAxMDoyOTo0NyI7czo3OiJ1c2VyX2lkIjtzOjI6Ijc0Ijt9fXM6NzoiUHJvZmlsZSI7YToxOntpOjA7YTo4OntzOjI6ImlkIjtzOjE6IjkiO3M6NzoidXNlcl9pZCI7czoyOiI3NCI7czo3OiJnYW1lX2lkIjtzOjE6IjIiO3M6OToiZ2FtZV9uYW1lIjtzOjE3OiJMZWFndWUgT2YgTGVnZW5kcyI7czo2OiJwc2V1ZG8iO3M6ODoiRmF5YWJvbWIiO3M6NToibGV2ZWwiO3M6ODoiaW5maW5pdGUiO3M6NzoiY3JlYXRlZCI7czoxOToiMjAxNC0wNS0yMSAxMDoyOTowNCI7czo4OiJtb2RpZmllZCI7czoxOToiMjAxNC0wNS0yMSAxMDoyOTowNCI7fX1zOjc6IkFydGljbGUiO2E6MTp7aTowO2E6NTp7czo1OiJ0aXRsZSI7czoyMjoiVEVTVDAwMDAwMDAwMDAwMDAwMDAwMCI7czoyOiJpZCI7czoyOiIxMiI7czo4OiJtb2RpZmllZCI7czoxOToiMjAxNC0wNS0yMSAxMDozODo1NSI7czo5OiJwdWJsaXNoZWQiO3M6MToiMCI7czo5OiJhdXRob3JfaWQiO3M6MjoiNzQiO319fXM6NzoiQ29tbWVudCI7YTozOntpOjA7YTo3OntzOjI6ImlkIjtzOjE6IjUiO3M6NDoiYm9keSI7czoxOToiQ0hBVFRFIGhhaGFoYWhhaGFoYSI7czo3OiJ1c2VyX2lkIjtzOjI6Ijc0IjtzOjc6InBvc3RfaWQiO3M6MToiNiI7czo3OiJjcmVhdGVkIjtzOjE5OiIyMDE0LTA1LTIxIDEwOjMwOjA4IjtzOjg6Im1vZGlmaWVkIjtzOjE5OiIyMDE0LTA1LTIxIDEwOjMwOjA4IjtzOjQ6IlVzZXIiO2E6Mjp7czo4OiJ1c2VybmFtZSI7czo3OiJSb2xsaW5nIjtzOjI6ImlkIjtzOjI6Ijc0Ijt9fWk6MTthOjc6e3M6MjoiaWQiO3M6MToiNiI7czo0OiJib2R5IjtzOjI5OiJpb2lvaW8gamUgcmVwb25kIGEgdG9uIHBvc3QgISI7czo3OiJ1c2VyX2lkIjtzOjI6IjYyIjtzOjc6InBvc3RfaWQiO3M6MToiNiI7czo3OiJjcmVhdGVkIjtzOjE5OiIyMDE0LTA1LTIxIDEwOjQxOjQ3IjtzOjg6Im1vZGlmaWVkIjtzOjE5OiIyMDE0LTA1LTIxIDEwOjQxOjQ3IjtzOjQ6IlVzZXIiO2E6Mjp7czo4OiJ1c2VybmFtZSI7czo4OiJkanVsbHMwNyI7czoyOiJpZCI7czoyOiI2MiI7fX1pOjI7YTo3OntzOjI6ImlkIjtzOjE6IjciO3M6NDoiYm9keSI7czo3OiJldWhoaCA/IjtzOjc6InVzZXJfaWQiO3M6MjoiNzIiO3M6NzoicG9zdF9pZCI7czoxOiI2IjtzOjc6ImNyZWF0ZWQiO3M6MTk6IjIwMTQtMDUtMjEgMTA6NTM6NDIiO3M6ODoibW9kaWZpZWQiO3M6MTk6IjIwMTQtMDUtMjEgMTA6NTM6NDIiO3M6NDoiVXNlciI7YToyOntzOjg6InVzZXJuYW1lIjtzOjg6ImRqdWxsczA5IjtzOjI6ImlkIjtzOjI6IjcyIjt9fX19czoxODoiY29udGVudF9mb3JfbGF5b3V0IjtzOjYwNzoiPGgxPiBUZXN0IDwvaDE+CjxkaXYgY2xhc3M9ImJhY2tncm91bmQiPgoKPHAgY2xhc3M9InBvc3RfYm9keSI+QklURSBISUhJSElISUhJSElISSBCSVRFPC9wPgoKPGRpdiBjbGFzcz0iY29tbWVudHMiPgoJPHA+Q0hBVFRFIGhhaGFoYWhhaGFoYSA8YnIgLz4KCTxzbWFsbD4KCQk8YSBocmVmPSIvQWdhbWVrL3VzZXJzL3ZpZXcvNzQiPlJvbGxpbmc8L2E+CTwvc21hbGw+PC9wPgoJPHA+aW9pb2lvIGplIHJlcG9uZCBhIHRvbiBwb3N0ICEgPGJyIC8+Cgk8c21hbGw+CgkJPGEgaHJlZj0iL0FnYW1lay91c2Vycy92aWV3LzYyIj5kanVsbHMwNzwvYT4JPC9zbWFsbD48L3A+Cgk8cD5ldWhoaCA/IDxiciAvPgoJPHNtYWxsPgoJCTxhIGhyZWY9Ii9BZ2FtZWsvdXNlcnMvdmlldy83MiI+ZGp1bGxzMDk8L2E+CTwvc21hbGw+PC9wPgo8L2Rpdj4KPC9kaXY+CjxkaXYgY2xhc3M9ImFjdGlvbnMiPgo8aDM+IFJlbGF0ZWQgYXRpb25zIDwvaDM+Cgk8dWw+Cgk8bGk+Cgk8YSBocmVmPSIvQWdhbWVrL3Bvc3RzL2VkaXQvNiI+RWRpdDwvYT48L2xpPgo8bGk+Cgk8YSBocmVmPSIvQWdhbWVrL2NvbW1lbnRzL2FkZC82Ij5BZGQgY29tbWVudDwvYT48L2xpPgoJPC91bD4KPC9kaXY+CiI7czoxODoic2NyaXB0c19mb3JfbGF5b3V0IjtzOjA6IiI7czoxNjoidGl0bGVfZm9yX2xheW91dCI7czo0OiJUZXN0Ijt9'));
				Router::setRequestInfo($controller->request);
				$this->request = $request;
				$controller->constructClasses();
				$controller->startupProcess();
				$this->viewVars = $controller->viewVars;
				$this->loadHelpers();
				extract($this->viewVars, EXTR_SKIP);
		?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <script type="text/javascript" src="/Agamek/js/jquery-2.1.1.min.js"></script>                <title>
            Agamek:
        </title>
        <link href="/Agamek/favicon.ico" type="image/x-icon" rel="icon" /><link href="/Agamek/favicon.ico" type="image/x-icon" rel="shortcut icon" /><link rel="stylesheet" type="text/css" href="/Agamek/css/cake.generic.css" />    </head>
    <body>
        <div id="container">
            <div id="header">
                
                <?php echo $this->element('menubar'); ?>
                
            </div>
            
            <div id="content">
                
                <h1> Test </h1>
<div class="background">

<p class="post_body">BITE HIHIHIHIHIHIHI BITE</p>

<div class="comments">
	<p>CHATTE hahahahahaha <br />
	<small>
		<a href="/Agamek/users/view/74">Rolling</a>	</small></p>
	<p>ioioio je repond a ton post ! <br />
	<small>
		<a href="/Agamek/users/view/62">djulls07</a>	</small></p>
	<p>euhhh ? <br />
	<small>
		<a href="/Agamek/users/view/72">djulls09</a>	</small></p>
</div>
</div>
<div class="actions">
<h3> Related ations </h3>
	<ul>
	<li>
	<a href="/Agamek/posts/edit/6">Edit</a></li>
<li>
	<a href="/Agamek/comments/add/6">Add comment</a></li>
	</ul>
</div>
            </div>
            <div id="footer">
                                <p>
                                    </p>
            </div>
        </div>
        
            <?php if (AuthComponent::user('role') == 'admin') echo $this->element('sql_dump');  ?>
        
    </body>
</html>
