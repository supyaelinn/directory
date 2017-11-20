<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en"> <![endif]-->
<html lang="en">

<head>
    <title>Business Directory</title>
    <meta name="description" content="Business Directory is a nationwide business directory where users can search for the businesses near them and write reviews." />
    <link rel="canonical" href="http://codebasedev.com/directoryapp/directoryapp_108" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon-precomposed" href="http://codebasedev.com/directoryapp/directoryapp_108/favicon/favicon-152.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="http://codebasedev.com/directoryapp/directoryapp_108/favicon/favicon-144.png">
    <link rel="icon" type="image/png" href="http://codebasedev.com/directoryapp/directoryapp_108/favicon/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css">
    <link rel="stylesheet" href="http://codebasedev.com/directoryapp/directoryapp_108/templates/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
    <!-- <script>
var baseurl = 'http://codebasedev.com/directoryapp/directoryapp_108';
</script> -->
</head>

<body class="tpl-index">
	 <nav class="navbar navbar-default">
	 	<div class="navbar-inner">
	 	<div class="navbar-header">
            <div id="logo">
               <!--  <a href="index.php"><img src="http://codebasedev.com/directoryapp/directoryapp_108/imgs/logo.png"></a> -->
            </div>

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="glyphicon glyphicon-menu-hamburger"></span>
		</button>
        </div>
    </div>	
	 </nav>
  	<!-- navigation -->

    <div class="search-block">
        <div class="search-block-inner">
            <form id="main-search-form">
                <div class="clearfix">
                    <input id="query-input" name="query" type="text" autocomplete="off" placeholder="I'm looking for...">

                    <div id="city-input-wrapper"><select id="city-input" name="city_id" /></select>
                    </div>

                    <button type="button" id="btn_search" class="btn btn-orange"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="wrapper" style="height:400px;">
    	<div class="full-block">
    		<div id="dataresults">
    			
    		</div>
    	</div>	
    </div>
    <!-- .wrapper .home-page -->

    <div id="footer">
        <div id="footer-inner">
            <div class="footer-inner-left">
                Business Directory </div>
            <div class="footer-inner-right">
                <ul>
                    <li><a href="about">About</a></li>
                    <li><a href="privacy-policy">Privacy Policy</a></li>
                    <li><a href="contact">Contact</a>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!-- #footer -->

    <!-- modal city change -->
    <div class="modal fade" id="change-city-modal" role="dialog" aria-labelledby="change-city-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title" id="myModalLabel">Select your city</h3>
                </div>
                <div class="modal-body">
                    <form id="city-change-form" method="post">
                        <div class="block"><select id="city-change" name="city-change"></select></div>
                    </form>
                </div>
                <!-- .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="clear-city">Clear City</button>
                </div>
            </div>
            <!-- .modal-content -->
        </div>
        <!-- .modal-dialog -->
    </div>
    <!-- end modal -->

    <!-- style sheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700,400italic,700italic">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="http://codebasedev.com/directoryapp/directoryapp_108/templates/lib/raty/jquery.raty.js"></script>
    <script src="http://codebasedev.com/directoryapp/directoryapp_108/lib/jquery-autocomplete/jquery.autocomplete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/en.js"></script>
    <script>
        /* SELECT2 */
        // #city-input (main search form in header)
  
        $('#city-input').select2({
            ajax: {
                url: 'searchWhere.php',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term, // search term
                        page: params.page
                    };
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            dropdownAutoWidth: true,
            placeholder: "Select a city",
            language: "en"
        });

        // #city-change (in modal triggered by navbar city change)
        $('#city-change').select2({
            ajax: {
                url: 'searchWhere.php',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        query: params.term, // search term
                        page: params.page
                    };
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            dropdownAutoWidth: true,
            placeholder: "Select a city",
            language: "en"
        });

        // $(document.body).on('change', '#city-change', function() {
        //     delete_cookie('city_name');
        //     createCookie('city_id', this.value, 90);
        //     location.reload(true);
        // });

        // $(document.body).on('click', '#clear-city', function(e) {
        //     e.preventDefault();
        //     delete_cookie('city_id');
        //     delete_cookie('city_name');
        //     location.reload(true);
        // });

        /* CUSTOM FUNCTIONS */
        // function createCookie(name, value, days) {
        //     var expires;
        //     var cookie_path;
        //     var path = "/directoryapp/directoryapp_108";

        //     if (days) {
        //         var date = new Date();
        //         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        //         expires = "; expires=" + date.toUTCString();
        //     } else {
        //         expires = "";
        //     }

        //     if (path != '') {
        //         cookie_path = "; path=" + path;
        //     } else {
        //         cookie_path = "";
        //     }

        //     document.cookie = name + "=" + value + expires + cookie_path;
        // }

        // function delete_cookie(name) {
        //     createCookie(name, "", -100);
        // }
    </script>

    <script type="text/javascript">
    	$("#btn_search").click(function(){
    		query = $("#query-input").val();
    		city = $("#city-input").text();
    		
    		$.ajax({
			    type: 'POST',
			    data: { 
			    		query: query,
			    		city :city
			        },
			    url: 'search.php',
			    dataType: 'html',
			    async: false,

			    success: function(result){
			        // call the function that handles the response/results
			        console.log(result);
			        $("#dataresults").html(result);
			    },

			    error: function(){
			        window.alert("Wrong query : " + query);
			    }
			  });
    	});
    </script>
    <!-- Start of StatCounter Code for Default Guide -->
    <!-- <script type="text/javascript">
        var sc_project = 10993392;
        var sc_invisible = 1;
        var sc_security = "958a1291";
        var scJsHost = (("https:" == document.location.protocol) ?
            "https://secure." : "http://www.");
        document.write("<sc" + "ript type='text/javascript' src='" +
            scJsHost +
            "statcounter.com/counter/counter.js'></" + "script>");
    </script> -->
    <!-- End of StatCounter Code for Default Guide -->
    <!-- set rating -->
    <!-- <script type="text/javascript">
        $.fn.raty.defaults.path = 'http://codebasedev.com/directoryapp/directoryapp_108/templates/lib/raty/images';
        $('.featured-item-rating').raty({
            readOnly: true,
            score: function() {
                return this.getAttribute('data-rating');
            }
        });
    </script> -->
</body>

</html>