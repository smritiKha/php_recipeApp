    $(document).ready(function(e) {

        $("#ad_status").change(function() {
            var status = $("#ad_status").val();
            if (status == "on") {
                $("#ad_status_on").show();
            } else {
                $("#ad_status_on").hide();
            }
            
        });

        $( window ).load(function() {
            var status = $("#ad_status").val();
            if (status == "on") {
                $("#ad_status_on").show();
            } else {
                $("#ad_status_on").hide();
            }
        });

        //primary ads
        $("#ad_type").change(function() {
            var type = $("#ad_type").val();
            if (type == "admob") {
                $("#admob_ads").show();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "startapp") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").show();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "unity") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").show();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "applovin") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").show();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "applovin_discovery") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").show();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "ironsource") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").show();
                $("#fan_ads").hide();
            }
            if (type == "google_ad_manager") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").show();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "fan") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").show();
            }
        });

        $(window).load(function() {
            var type = $("#ad_type").val();
            if (type == "admob") {
                $("#admob_ads").show();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "startapp") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").show();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "unity") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").show();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "applovin") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").show();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "applovin_discovery") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").show();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "ironsource") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").show();
                $("#fan_ads").hide();
            }
            if (type == "google_ad_manager") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").show();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").hide();
            }
            if (type == "fan") {
                $("#admob_ads").hide();
                $("#ad_manager_ads").hide();
                $("#startapp_ads").hide();
                $("#unity_ads").hide();
                $("#applovin_max_ads").hide();
                $("#applovin_discovery_ads").hide();
                $("#ironsource_ads").hide();
                $("#fan_ads").show();
            }
        });

        //backup ads
        $("#backup_ads").change(function() {
            var type = $("#backup_ads").val();
            if (type == "none") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "admob") {
                $("#admob_ads_backup").show();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "startapp") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").show();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "unity") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").show();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "applovin") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").show();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "applovin_discovery") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").show();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "ironsource") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").show();
                $("#fan_ads_backup").hide();
            }
            if (type == "google_ad_manager") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").show();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "fan") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").show();
            }
        });

        $(window).load(function() {
            var type = $("#backup_ads").val();
            if (type == "none") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "admob") {
                $("#admob_ads_backup").show();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "startapp") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").show();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "unity") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").show();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "applovin") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").show();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "applovin_discovery") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").show();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "ironsource") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").show();
                $("#fan_ads_backup").hide();
            }
            if (type == "google_ad_manager") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").show();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").hide();
            }
            if (type == "fan") {
                $("#admob_ads_backup").hide();
                $("#ad_manager_ads_backup").hide();
                $("#startapp_ads_backup").hide();
                $("#unity_ads_backup").hide();
                $("#applovin_max_ads_backup").hide();
                $("#applovin_discovery_ads_backup").hide();
                $("#ironsource_ads_backup").hide();
                $("#fan_ads_backup").show();
            }
        });

    });