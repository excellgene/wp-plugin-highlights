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
                    let URLguid = category.url_post;
                    let excerptPost = category.excerpt;

                    let element;
                    if (categoryName === "events") {
                        element = $('<div class="events"></div>').html(
                            `	<div class="postHeader"> 
                                <p class="date"> ${postDate}</p>
                                <p class="label">${categoryName}</p>
                                </div>
                                <h2 class="title">${latestPostTitle}</h2>
                                <a href="https://informaconnect.com/bioeurope/" class="button-35"> Visit Bio-Europe </a>
                            `
                        );
                        element.click(function () {
                            window.location.href = "https://informaconnect.com/bioeurope/";
                        });
                    } else {
                        element = $('<div class="content"></div>').html(
                            `<div class="postHeader"> 
                            <p class="date"> ${postDate}</p>
                            <p class="label">${categoryName}</p>
                            </div>
                                <h2 class="title">${latestPostTitle}</h2>

                           `
                        );
                        element.click(function () {
                            window.location.href = `${URLguid}`;
                        });
                    }

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

                    $('#blogsHighlight').append(element);

                });
            }
        })
})(jQuery);


