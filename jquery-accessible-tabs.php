<?php
/*
Plugin Name: JQuery Accessible Tabs
Plugin URI: http://wordpress.org/extend/plugins/jquery-accessible-tabs/
Description: WAI-ARIA Enabled Tabs Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 3.0
Author URI: http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
include_once 'getRecentPosts.php';
include_once 'getRecentComments.php';
include_once 'getArchives.php';

add_action("plugins_loaded", "JQueryAccessibleTabs_init");
function JQueryAccessibleTabs_init() {
    register_sidebar_widget(__('JQuery Accessible Tabs'), 'widget_JQueryAccessibleTabs');
    register_widget_control(   'JQuery Accessible Tabs', 'JQueryAccessibleTabs_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_JQueryAccessibleTabs') ) {
        wp_register_style('jquery.ui.all', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tabs/lib/jquery-ui/themes/base/jquery.ui.all.css'));
        wp_enqueue_style('jquery.ui.all');

        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('jquery-1.6.4', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tabs/lib/jquery-ui/jquery-1.6.4.js'));
        wp_enqueue_script('jquery-1.6.4');

        wp_register_script('jquery.ui.core.js', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tabs/lib/jquery-ui/ui/jquery.ui.core.js'));
        wp_enqueue_script('jquery.ui.core.js');

        wp_register_script('jquery.ui.widget', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tabs/lib/jquery-ui/ui/jquery.ui.widget.js'));
        wp_enqueue_script('jquery.ui.widget');

        wp_register_script('jquery.ui.tabs', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tabs/lib/jquery-ui/ui/jquery.ui.tabs.js'));
        wp_enqueue_script('jquery.ui.tabs');

        wp_register_style('demo', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tabs/lib/demo.css'));
        wp_enqueue_style('demo');

        wp_register_script('JQueryAccessibleTabs', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tabs/lib/JQueryAccessibleTabs.js'));
        wp_enqueue_script('JQueryAccessibleTabs');
    }
}

function widget_JQueryAccessibleTabs($args) {
    extract($args);

    $options = get_option("widget_JQueryAccessibleTabs");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Tabs',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    JQueryAccessibleTabsContent();
    echo $after_widget;
}

function JQueryAccessibleTabsContent() {
    $recentPosts = get_recent_posts();
    $recentComments = get_recent_comments();
    $archives = get_my_archives();

    $options = get_option("widget_JQueryAccessibleTabs");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Tabs',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo '	<div class="demo" role="application">
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">' . $options['archives'] . '</a></li>
						<li><a href="#tabsdemo-2">' . $options['recentPosts'] . '</a></li>
						<li><a href="#tabsdemo-3">' . $options['recentComments'] . '</a></li>
					</ul>
				   
					<div id="tabs-1">
						<p><ul>' . $archives . '</ul></p>
					</div>
					
					<div id="tabsdemo-2">
						 <p><ul>' . $recentPosts . '</ul></p>
					</div>
					
					<div id="tabsdemo-3">
						<p><ul>' . $recentComments . '</ul></p>
					</div>
				</div>

			</div>';
		}

function JQueryAccessibleTabs_control() {
    $options = get_option("widget_JQueryAccessibleTabs");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'JQuery Accessible Tabs',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    if ($_POST['JQueryAccessibleTabs-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['JQueryAccessibleTabs-WidgetTitle']);
        update_option("widget_JQueryAccessibleTabs", $options);
    }
    if ($_POST['JQueryAccessibleTabs-SubmitArchives']) {
        $options['archives'] = htmlspecialchars($_POST['JQueryAccessibleTabs-WidgetArchives']);
        update_option("widget_JQueryAccessibleTabs", $options);
    }
    if ($_POST['JQueryAccessibleTabs-SubmitRecentPosts']) {
        $options['recentPosts'] = htmlspecialchars($_POST['JQueryAccessibleTabs-WidgetRecentPosts']);
        update_option("widget_JQueryAccessibleTabs", $options);
    }
    if ($_POST['JQueryAccessibleTabs-SubmitRecentComments']) {
        $options['recentComments'] = htmlspecialchars($_POST['JQueryAccessibleTabs-WidgetRecentComments']);
        update_option("widget_JQueryAccessibleTabs", $options);
    }
    ?>
    <p>
        <label for="JQueryAccessibleTabs-WidgetTitle">Widget Title: </label>
        <input type="text" id="JQueryAccessibleTabs-WidgetTitle" name="JQueryAccessibleTabs-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="JQueryAccessibleTabs-SubmitTitle" name="JQueryAccessibleTabs-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTabs-WidgetArchives">Translation for "Archives": </label>
        <input type="text" id="JQueryAccessibleTabs-WidgetArchives" name="JQueryAccessibleTabs-WidgetArchives" value="<?php echo $options['archives'];?>" />
        <input type="hidden" id="JQueryAccessibleTabs-SubmitArchives" name="JQueryAccessibleTabs-SubmitArchives" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTabs-WidgetRecentPosts">Translation for "Recent Posts": </label>
        <input type="text" id="JQueryAccessibleTabs-WidgetRecentPosts" name="JQueryAccessibleTabs-WidgetRecentPosts" value="<?php echo $options['recentPosts'];?>" />
        <input type="hidden" id="JQueryAccessibleTabs-SubmitRecentPosts" name="JQueryAccessibleTabs-SubmitRecentPosts" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTabs-WidgetRecentComments">Translation for "Recent Comments": </label>
        <input type="text" id="JQueryAccessibleTabs-WidgetRecentComments" name="JQueryAccessibleTabs-WidgetRecentComments" value="<?php echo $options['recentComments'];?>" />
        <input type="hidden" id="JQueryAccessibleTabs-SubmitRecentComments" name="JQueryAccessibleTabs-SubmitRecentComments" value="1" />
    </p>
    
    <?php
}

?>
