<?php

get_header();

$biz_act = [
    ['Global Work Marketplace', 'marketplace'],
    ['Integrated Facilities Management', 'manage'],
    ['Information Technology', 'it'],
];

?>
<link href="https://unpkg.com/treeflex/dist/css/treeflex.css" rel="stylesheet">
<main>
    <div id="about_heading" class="bg-azure py-6">
        <div class="container uppercase font-display">
            <h5 class="text-4xl text-cetacean">Who we are and what drives us</h5>
            <h2 class="text-7xl text-white">Our Story</h2>
        </div>
    </div>
    <div id="about_body" class="bg-left md:bg-center bg-cover bg-no-repeat py-12" style="background-image: url(<?php echo get_bloginfo('template_url'); ?>/img/pages/about-us-bg.png);">
        <div class="container">
            <div class="w-full md:w-1/3 to-animate -translate-x-10 delay-75">
                <p>From humble beginnings to becoming a premier talent acquisition platform in Singapore, Malaysia and Thailand, we've dedicated ourselves to empowering businesses with the right people, strategies and solutions. Our state-of-the-art job finder app has earned its place among the top 10 Singapore job apps on the Google Play Store. Catering to both job seekers and employers, our app enables seamless job posting, efficient candidate search for full-time & part-time positions, secured salary transactions through e-wallet, as well as a rewarding experience with our exclusive rewards points program.</p>
            </div>
        </div>
    </div>
    <div id="about_activities" class="container py-12">
        <h3 class="text-center text-chocolate text-3xl font-semibold mb-6">The Group’s primary business activities are:</h3>
        <div class="flex gap-5 justify-between md:w-1/2 mx-auto to-animate translate-y-10">
            <?php $biz_counter = 1; foreach($biz_act as $item): ?>
            <div class="flex flex-col gap-3 items-center">
                <div class="h-12 w-12 rounded-full flex items-center justify-center text-white bg-chocolate">
                    <?php echo $biz_counter;?>
                </div>
                <h6 class="text-center"><a href="<?php site_url($item[1]);?>"><?php echo $item[0];?></a></h6>
            </div>
            <?php $biz_counter ++; endforeach;?>
        </div>
    </div>
    <div id="about_group_structure" class="py-12">
        <h3 class="text-center text-3xl font-semibold mb-6 text-chocolate">Our Group Structure</h3>
        <div id="about_group_structure_map" class="relative">
            <img src="<?php echo get_bloginfo('template_url'); ?>/img/pages/about-us-map.webp)" class="w-full max-w-full h-auto mx-auto" alt="YY Group SEA" />
            <img id="myPin" src="<?php echo get_bloginfo('template_url'); ?>/img/pages/about-us-my-pin.webp)" class="to-animate -translate-y-5 delay-100 absolute top-[6rem] left-[22.7rem]" width="80" height="116" alt="YY Group SEA - MY" />
            <img id="sgPin" src="<?php echo get_bloginfo('template_url'); ?>/img/pages/about-us-sg-pin.webp)" class="to-animate -translate-y-5 delay-500 absolute top-[12rem] left-[25.5rem]" width="80" height="128" alt="YY Group SEA - SG">
            <div id="myInfo" class="opacity-0 pointer-events-none transition-all delay-75 absolute flex w-1/2 items-center top-5 right-56">
                <div class="z-10">
                    <div class="w-40 h-40 -mr-20">
                        <img src="<?php echo get_bloginfo('template_url'); ?>/img/pages/ir/ken-teng.webp" class="object-cover object-center rounded-full w-full" />
                    </div>
                </div>
                <div class="border-2 rounded-2xl border-chocolate py-3 pr-6 pl-24 flex flex-col bg-white/80 relative">
                    <h6 class="font-bold text-azure uppercase">Ken Teng</h6>
                    <span>Group CIO</span>
                    <span>Malaysia Country Manager</span>
                    <ul class="list-disc list-inside mt-4">
                        <li>Ken is the Director of the YY Circle Sdn. Bhd.</li>
                        <li>He has over 12 years of experience in leading and delivering the digitalization and automation of business processes for corporate organizations.</li>
                        <li>Ken holds a Bachelor's Degree in Information Technology.</li>
                    </ul>
                    <!-- <button id="myClose" class="-top-5 absolute -right-5 bg-chocolate text-white px-2 py-1 rounded-full h-10 w-10 font-bold">X</button> -->
                </div>
            </div>
            <div id="sgInfo" class="opacity-0 pointer-events-none transition-all delay-75 absolute flex w-1/2 items-center bottom-5 right-40">
                <div class="z-10">
                    <div class="w-40 h-40 -mr-20">
                        <img src="<?php echo get_bloginfo('template_url'); ?>/img/pages/ir/mike-fu.webp" class="object-cover object-center rounded-full w-full" />
                    </div>
                </div>
                <div class="border-2 rounded-2xl border-chocolate py-3 pr-6 pl-24 flex flex-col bg-white/80 relative">
                    <h6 class="font-bold text-azure uppercase">Mike Fu</h6>
                    <span>Founder and Group CEO</span>
                    <span>Singapore Country Manager</span>
                    <ul class="list-disc list-inside mt-4">
                        <li>Mike is the founder of YY Group & has more than 10 years of experience in casual labor manpower management and business strategic planning.</li>
                        <li>He was recognized as Entrepreneur of the Year in 2015 by the Association of Small and Medium Enterprises and the Rotary Club of Singapore.</li>
                    </ul>
                    <!-- <button id="sgClose" class="-top-5 absolute -right-5 bg-chocolate text-white px-2 py-1 rounded-full h-10 w-10 font-bold">X</button> -->
                </div>
            </div>
        </div>
        <div id="about_group_structure_tree" class="to-animate -translate-y-10 delay-75 tf-tree container text-center my-12">
            <ul>
                <li>
                    <span class="tf-nc !border-0 !py-6 !px-4 bg-[#3a88bd] text-white font-semibold text-center">YY Group Holding Limited<br/>(BVI)</span>
                    <ul>
                        <li class="">
                            <span class="tf-nc !border-0 bg-[#03a89e] h-full !py-6 px-3 text-white font-semibold text-center">
                                <a href="https://yycircle.com/" target="_blank">YY Circle (SG) Pte Ltd<br/>(Singapore)</a>
                            </span>
                        </li>
                        <li class="">
                            <span class="tf-nc !border-0 bg-[#03a89e] h-full !py-6 px-3 text-white font-semibold text-center">
                                <a href="https://yycircle.com/" target="_blank">Hong Ye Group Pte Ltd<br/>(Singapore)</a>
                            </span>
                        </li>
                        <li class="">
                            <span class="tf-nc !border-0 bg-[#03a89e] h-full !py-6 px-3 text-white font-semibold text-center">YY Circle Sdn Bhd<br/>(Malaysia)</span>
                        </li>
                        <li class="">
                            <span class="tf-nc !border-0 bg-[#03a89e] h-full !py-6 px-3 text-white font-semibold text-center">Hong Ye Maintenance (MY) Sdn Bhd<br/>(Malaysia)</span>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div id="about_cta" class="bg-cetacean p-10 border-b-4 border-gray-200 to-animate translate-y-5 delay-100">

		<div class="container flex flex-col md:flex-row gap-10">

			<div class="md:w-2/3 text-white flex flex-col md:flex-row">
				<div><img src="<?php echo get_bloginfo('template_url'); ?>/img/pages/market/yy-market-i.webp" class="mx-auto"></div>
				<div class="self-center">
					<h4 class="text-2xl font-display font-bold">Ready to learn more?</h4>
					<p>Have questions or want to explore how our platform can benefit your organization? Reach out to us for a personalized consultation.</p>
				</div>
			</div>

			<div class="md:w-1/3 text-center md:self-center"> 
				<a href="/contact-us"><button class="bg-chocolate px-5 py-2 text-sm text-white rounded-full">Contact Us</button></a>
			</div>	
		</div>

	</div>
</main>
<script>
    const myPin = document.getElementById("myPin");
    const sgPin = document.getElementById("sgPin");
    const myInfo = document.getElementById("myInfo");
    const sgInfo = document.getElementById("sgInfo");
    const myClose = document.getElementById("myClose");
    const sgClose = document.getElementById("sgClose");

    myPin.addEventListener("click", () => {
        myInfo.style.opacity = 1;
        myInfo.style.transform = "translateX(0)";
    });

    sgPin.addEventListener("click", () => {
        sgInfo.style.opacity = 1;
        sgInfo.style.transform = "translateX(0)";
    });

    myClose.addEventListener("click", () => {
        myInfo.style.opacity = 0;
        myInfo.style.transform = "translateX(-100%)";
    });

    sgClose.addEventListener("click", () => {
        sgInfo.style.opacity = 0;
        sgInfo.style.transform = "translateX(100%)";
    });
</script>
<?php get_footer();?>