(function ($) {


	
	$.ajax({
		url: url,
		type: "POST",
		global: false,
		data: {
			'action': 'get_latest_post',
		}
	})
		.done(function (results) {
			let data = JSON.parse(results);


			if (data.json && data.json.length > 0) {
				data.json.forEach(category => {
					let latestPostTitle = category.latest_post;
					let postDate = category.date;
					let categoryName = category.category;
					let URLguid = category.url_post
					let element;

					function addZero(n) {
						return n < 10 ? '0' + n : n;
					}

					let formattedDate = new Date(postDate);
					let day = addZero(formattedDate.getDate());
					let month = addZero(formattedDate.getMonth() + 1);
					let year = formattedDate.getFullYear();



					if (categoryName === "Events") {
						element = $('<div class="events"></div>').html(
							`	<div class="postHeader"> 
								<p class="date"> ${year}/${month}/${day}</p>
								<p class="label">${categoryName}</p>
								</div>
								<h2 class="title">${latestPostTitle}</h2>
								<a href=${URLguid} class="button-35"> Read more </a>
							`

						);
					} else {
						element = $('<div class="content"></div>').html(
							` <div class="postHeader"> 
							<p class="date"> ${year}/${month}/${day}</p>
							<p class="label">${categoryName}</p>
							</div>
          					 <h2 class="title">${latestPostTitle}</h2>
							   <a href=${URLguid} class="button-35"> Read more </a>
						   `
						);
					}

					$(document).ready(function () {
						let events = $('.events');
						let content = $('.content');

						events.each(function (index) {
							if (index === 0) {
								$(this).css('grid-area', 'area5');
							}
						});

						content.each(function (index) {
							$(this).css('grid-area', 'area' + (index));
						});

				
					});



					// Ajoutez l'élément à la page
					$('#blogsHighlight').append(element);
				});
			}
		})
	

})(jQuery);
