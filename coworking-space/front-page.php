<?php
get_header();

echo '<main class="flex flex-col gap-20">';

get_template_part( 'content/front/hero' );
get_template_part( 'content/front/spaces' );
get_template_part( 'content/front/highlights' );
get_template_part( 'content/front/others' );
get_template_part( 'content/front/cta' );
//get_template_part( 'content/front/financials' );
//get_template_part( 'content/front/clients' );
//get_template_part( 'content/front/cta' );
//get_template_part( 'content/front/business' );

echo '</main>';
get_footer();
?>