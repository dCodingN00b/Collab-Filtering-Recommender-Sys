<?php session_start();

$part = '';
if (isset($_GET['part'])){
	echo 'yes';
	$part = $_GET['part'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Documentation Layout</title>
	<link rel="stylesheet" type="text/css" href="doc_style.css?version3">
	<script>
	// Highlight the active section in the sidebar
	window.addEventListener('scroll', function() {
	var sections = document.querySelectorAll('h1');
	var sidebarLinks = document.querySelectorAll('.sidebar a');
	var currentSection = '';

	for (var i = 0; i < sections.length; i++) {
		var section = sections[i];

		if (section.offsetTop - window.innerHeight / 2 < window.scrollY) {
			currentSection = section.getAttribute('id');
		}
	}

	for (var i = 0; i < sidebarLinks.length; i++) {
		var sidebarLink = sidebarLinks[i];

		if (sidebarLink.getAttribute('href').substring(1) == currentSection) {
			sidebarLink.classList.add('active');
		} else {
			sidebarLink.classList.remove('active');
		}
	}
});

	</script>
</head>
<body>
	<div class="sidebar">
		<ul>
			<li><a href="documentation.php?part=introduction">Introduction</a></li>
			<li><a href="#section2">Section 2</a></li>
			<li><a href="#section3">Section 3</a></li>
		</ul>
	</div>
	<?php
	if ($part == '' or $part == 'introduction'){ 
		echo" <div class='content'>
			<h1 id='section1'>Introduction</h1>
			<p>RECS is a website-based product where it offers our clients the ability to predict existing user’s rating and preferences on different items as well as providing recommendations on similar or other products that the specific user might be interested in based on the data set input by the owner. Our client can add new products to the recommender system that they have not added before into their e-commerce site to generate a predicted rating for the products and make more informed decisions based on the result of the predictions returned. While for our customer, the system allows them to predict and get recommendations of similar items on a single item from the data we web crawl in other websites. 
</p></br></br></br></br>
			<h1 id='section2'>How It Works</h1>
			<p>Phasellus ultrices auctor felis, sit amet varius mi venenatis sit amet. Sed suscipit laoreet tellus, ac ultricies dolor commodo id. Nunc ac nisl vel purus mollis ultrices. Aenean nec purus vel tortor laoreet consequat. Morbi eget ornare ipsum, sed tristique justo. Aliquam erat volutpat. Nullam efficitur eleifend arcu quis venenatis. Ut ac gravida enim. Duis ultrices odio mi, nec hendrerit dolor sagittis eu.</p>
			</br></br></br></br>
			<h1 id='section3'>Organization</h1>
			<p>Nunc aliquet felis felis, id semper purus maximus ac. Donec euismod pharetra elit, vel fringilla ipsum bibendum non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam id turpis vel odio finibus congue eu a nisi. Vivamus accumsan consectetur metus a interdum. Duis fringilla odio et leo lobortis luctus. Etiam aliquam enim et mauris imperdiet, id rhoncus tortor consectetur. Nullam varius sapien a justo faucibus varius. Pellentesque ultricies ex eget sapien faucibus, quis convallis ipsum malesuada. Duis eu nunc velit.</p>
		</div>";
	}
	?>
</body>
</html>
