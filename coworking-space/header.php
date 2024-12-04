<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php language_attributes(); ?>"> <!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="apple-touch-icon" href="apple-touch-icon.png">

	<?php wp_head(); ?>

	<?php do_action('after_wp_head');?>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@100..900&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="<?php echo get_theme_file_uri( '/js/giyo-animations.js' ); ?>" defer></script>
	<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src='https://www.google.com/recaptcha/api.js?badge=bottomleft'></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

	<script>
		tailwind.config = {
			theme: {
				extend: {
					colors: {
						'golden-grass': {
							'50': '#fcf9ea',
							'100': '#f8f1c9',
							'200': '#f2e196',
							'300': '#eac95a',
							'400': '#e1ad21',
							'500': '#d39a1f',
							'600': '#b67818',
							'700': '#915617',
							'800': '#79451a',
							'900': '#673b1c',
							'950': '#3c1e0c',
						},
					},
				},
				container: {
				center: true,
					padding: {
						DEFAULT: '1rem',
						sm: '2rem',
						lg: '4rem',
						xl: '5rem',
					},
				},
				fontFamily: {
					display: ['Commissioner', 'sans-serif'],
					body:  ['Commissioner', 'sans-serif'],
					sans: ['Commissioner', 'sans-serif'],
					serif: ['PT Serif', 'serif'],
				},
			}
		}
	</script>
	<style type="text/tailwindcss">
		@layer utilities {
			.to-animate {
				@apply opacity-0 duration-1000 ease-in-out transition-all;
			}
			.animated {
				@apply opacity-100 translate-x-0 translate-y-0 scale-100 rotate-0;
			}
			.hover-scale {
				/* @apply hover:scale-105 transition-transform ease-in-out delay-100 */
				@apply hover:animate-scale transition-transform;
			}
			/**wp the_content classes override**/
			.aligncenter {
				@apply m-auto mb-4;
			}
			.alignright {
				@apply ml-auto mr-auto md:float-right md:ml-6 md:mr-0 clear-both mb-4;
			}
			
			.alignleft {
				@apply ml-auto mr-auto md:float-left md:ml-0 md:mr-6 clear-both mb-4;
			}
			
			.wp-caption.aligncenter, .gallery-caption {
				@apply text-center;
			}
			
			.wp-caption.aligncenter img {
				@apply w-full;
			}

			.wp-caption-text {
				@apply text-sm;
			}
			.gallery.gallery-columns-4 {
				@apply grid grid-flow-row grid-cols-2 lg:grid-cols-4 gap-10;
			}
			.gallery.gallery-columns-3 {
				@apply grid grid-flow-row md:grid-cols-3 gap-10;
			}
			.gallery.gallery-columns-2 {
				@apply grid grid-flow-row md:grid-cols-2 gap-10;
			}
			.gallery-item img {
				@apply mx-auto mb-3;
			}
		}
		* {
			/* scrollbar-width: thin; */
			/* scrollbar-color: var(--secondary) var(--primary); */
		}
		html {
			@apply scroll-smooth;
			/* font-family: 'PT Serif', 'serif'; */
			@apply selection:bg-golden-grass-400 selection:text-black
		}
		.to-animate, .animate-fill-box {
			transform-box: fill-box;
		}
		.menu-item.dropdown:hover .dropdown-menu {
			display: block;
		}

		.dropdown-item.active, .dropdown-item:active {
			@apply bg-golden-grass-400;
		}

		.menu-quick-links-container .menu-item a:hover {
			@apply text-golden-grass-600;
		}

  	</style>


</head>
<body <?php body_class('main-body'); ?>>
	<nav id="headerMain">
		<div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
			<div class="relative flex h-16 items-center justify-between">
			<div class="absolute inset-y-0 left-0 flex items-center lg:hidden">
				<!-- Mobile menu button-->
				 
				<button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" data-bs-toggle="offcanvas" data-bs-target="#mobile-menu">
					<span class="absolute -inset-0.5"></span>
					<span class="sr-only">Open main menu</span>
					<!--
						Icon when menu is closed.

						Menu open: "hidden", Menu closed: "block"
					-->
					<svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
					</svg>
					<!--
						Icon when menu is open.

						Menu open: "block", Menu closed: "hidden"
					-->
					<svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
			<div class="flex flex-1 items-center justify-center sm:items-stretch lg:justify-start">
				<div class="flex flex-shrink-0 items-center">
					<a href="<?php echo get_bloginfo('url');?>">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.svg" alt="Intellidesk Coworking Space" class="h-10">
					</a>
				</div>
				<?php
					wp_nav_menu([
						'menu'            => 'main',
						'theme_location'  => 'main',
						'container'       => 'nav',
						'container_id'    => 'main_nav',
						'container_class' => 'hidden sm:ml-6 lg:block w-full lg:mt-4',
						'menu_id'         => false,
						'menu_class'      => 'flex font-display text-center justify-between',
						//'depth'         => 2,
						'fallback_cb'     => 'bs4navwalker::fallback',
						'walker'          => new bs4navwalker(),
					]);
				?>
			</div>
			<div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
				<!-- Profile dropdown -->
				<div class="relative ml-3">
					<div>
						<!-- <button type="button" class="relative flex text-sm" id="user-menu-button" aria-expanded="false" aria-haspopup="true"> -->
						<a href="<?php echo get_site_url().'/my-account';?>" class="relative flex text-sm" id="user-menu-button">
						<span class="absolute -inset-1.5"></span>
						<span class="sr-only">Open user menu</span>
							<svg width="30px" height="30px" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>user-profile-filled</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="drop" fill="#e1ad21" transform="translate(42.666667, 42.666667)"> <path d="M213.333333,3.55271368e-14 C269.912851,3.55271368e-14 324.175019,22.4761259 364.18278,62.4838867 C404.190541,102.491647 426.666667,156.753816 426.666667,213.333333 C426.666667,331.15408 331.15408,426.666667 213.333333,426.666667 C95.5125867,426.666667 2.84217094e-14,331.15408 2.84217094e-14,213.333333 C2.84217094e-14,95.5125867 95.5125867,3.55271368e-14 213.333333,3.55271368e-14 Z M234.666667,234.666667 L192,234.666667 C139.18529,234.666667 93.8415802,266.653822 74.285337,312.314895 C105.229171,355.70638 155.977088,384 213.333333,384 C270.689579,384 321.437496,355.70638 352.381644,312.31198 C332.825087,266.653822 287.481377,234.666667 234.666667,234.666667 L234.666667,234.666667 Z M213.333333,64 C177.987109,64 149.333333,92.653776 149.333333,128 C149.333333,163.346224 177.987109,192 213.333333,192 C248.679557,192 277.333333,163.346224 277.333333,128 C277.333333,92.653776 248.679557,64 213.333333,64 Z" id="Combined-Shape"> </path> </g> </g> </g></svg>
						<!-- </button> -->
						</a>
					</div>
				</div>
			</div>
			</div>
		</div>
	</nav>

<div class="offcanvas offcanvas-start bg-cetacean" tabindex="-1" id="mobile-menu" aria-labelledby="mobile-menu">
	<div class="offcanvas-header justify-end flex">
		<button type="button" class="self-end filter btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
			<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M0 13.2457C0 5.93029 5.93029 0 13.2457 0C20.5611 0 26.4912 5.93029 26.4912 13.2457C26.4912 20.5609 20.5611 26.4913 13.2457 26.4913C5.93029 26.4913 0 20.5609 0 13.2457ZM13.2457 1.89999C6.97963 1.89999 1.90001 6.97963 1.90001 13.2457C1.90001 19.5117 6.97963 24.5913 13.2457 24.5913C19.5117 24.5913 24.5912 19.5117 24.5912 13.2457C24.5912 6.97963 19.5117 1.89999 13.2457 1.89999ZM17.953 8.53879C18.3435 8.92931 18.3435 9.56249 17.953 9.95301L14.6601 13.2459L17.953 16.5388C18.3435 16.9293 18.3435 17.5625 17.953 17.953C17.5625 18.3435 16.9293 18.3435 16.5388 17.953L13.2459 14.6601L9.95301 17.953C9.56249 18.3435 8.92931 18.3435 8.53879 17.953C8.14827 17.5625 8.14827 16.9293 8.53879 16.5388L11.8317 13.2459L8.53879 9.95301C8.14827 9.56249 8.14827 8.92931 8.53879 8.53879C8.92931 8.14827 9.56249 8.14827 9.95301 8.53879L13.2459 11.8317L16.5388 8.53879C16.9293 8.14827 17.5625 8.14827 17.953 8.53879Z" fill="black"></path>
			</svg>
		</button>
	</div>
	<div class="offcanvas-body w-10/12 mx-auto">
		<?php	
			wp_nav_menu([
				'menu'            => 'main',
				'theme_location'  => 'main',
				'container'       => 'div',
				'container_id'    => 'mobile_nav',
				'container_class' => '',
				'menu_id'         => false,
				'menu_class'      => 'text-lg flex flex-col font-semibold divide-y',
				//'depth'         => 2,
				'fallback_cb'     => 'bs4navwalker::fallback',
				'walker'          => new menuMobileWalker()
			]);
		?>
	</div>
</div>

<!-- end of header -->
<!-- start of main content -->

