<div class="pageheader">
  <h2> <i class="fa fa-home"></i>
    Dashboard
    <span><?php echo Language::get('home.header.overview'); ?></span>
  </h2>
  <div class="breadcrumb-wrapper">
    <span class="label"><?php echo Language::get('global.entry.youarehere'); ?>:</span>
    <ol class="breadcrumb">
      <li>
        <a href="/home/index">Loreji</a>
      </li>
      <li class="active">Dashboard</li>
    </ol>
  </div>
</div>

<div class="contentpanel">

  <div class="row">

      <div class="col-md-2 col-md-offset-3">
        <div class="alert alert-success" id="updatemessage" style="display: none;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?php echo Text::widont(Language::get('home.popup.update')); ?>
            </div>
        </div>

    <div class="col-sm-12 col-md-12">
    <?php 
      Counter::init(Auth::check_login()['au_id_in']);
    ?>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">

            <!-- col-sm-8 -->
            <div class="col-sm-4">
              <h5 class="subtitle mb5"><?php echo Language::get('home.admin.serverstatus'); ?></h5>
              <p class="mb15"><?php echo Language::get('home.admin.serverstatus.desc'); ?></p>

              <?php
                // Build CPU info
              $system_cpu = System::Avg_load()['sys'];
              if($system_cpu < '15'){
                $statuscpu = 'progress-bar-success';
              }

              if($system_cpu > '49'){
                $statuscpu = 'progress-bar-warning';
              }

              if($system_cpu > '80'){
                $statuscpu = 'progress-bar-danger';
              }
              ?>
              <span class="sublabel"><?php echo Language::get('home.admin.cpuusage'); ?> (<?php echo $system_cpu; ?>%)</span>
              <div class="progress progress-sm">
                <div style="width: <?php echo $system_cpu; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $system_cpu; ?>" role="progressbar" class="progress-bar <?php echo $statuscpu; ?>"></div>
              </div>
              <!-- progress -->

              <?php 
                // Build RAM info
              $statusram = '';
              $system_ram = System::Ram_usage();
              if($system_ram['percentage_1'] < '30'){
                $statusram = 'progress-bar-success';
              }

              if($system_ram['percentage_1'] > '49'){
                $statusram = 'progress-bar-warning';
              }

              if($system_ram['percentage_1'] > '80'){
                $statusram = 'progress-bar-danger';
              }
              ?>
              <span class="sublabel"><?php echo Language::get('home.admin.ramusage'); ?> (<?php echo $system_ram['percentage_1']; ?>%)</span>
              <div class="progress progress-sm">
                <div style="width: <?php echo $system_ram['percentage_1']; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $system_ram['percentage_1']; ?>" role="progressbar" class="progress-bar <?php echo $statusram; ?>"></div>
              </div>
              <!-- progress -->

              <?php
              $system_hdd = System::Disk_usage();
              if($system_hdd['percentage'] < '15'){
                $statushdd = 'progress-bar-success';
              }

              if($system_hdd['percentage'] > '49'){
                $statushdd = 'progress-bar-warning';
              }

              if($system_hdd['percentage'] > '80'){
                $statushdd = 'progress-bar-danger';
              }
              ?>
              <span class="sublabel"><?php echo Language::get('home.admin.diskusage'); ?> (<?php echo $system_hdd['percentage']; ?>%)</span>
              <div class="progress progress-sm">
                <div style="width: <?php echo $system_hdd['percentage']; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $system_hdd['percentage']; ?>" role="progressbar" class="progress-bar <?php echo $statushdd; ?>"></div>
              </div>
              <!-- progress -->
              <!-- col-sm-4 --> 
            </div>

            <div class="clearfix visible-xs" style="padding-top:10px;"><hr /></div>

            <!-- Server statusses -->
            <div class="col-sm-4">
              <h5 class="subtitle mb5"><?php echo Language::get('home.admin.serverinfo'); ?></h5>
              <p class="mb15"><?php echo Language::get('home.admin.serverinfo.desc'); ?></p>
              <span class="sublabel" style="padding-bottom: 5px;"><div class="left"><strong><?php echo Language::get('home.admin.serverip'); ?></strong>:</div> <?php echo System::Remote_ip(); ?></span>
              <span class="sublabel" style="padding-bottom: 5px;"><div class="left"><strong><?php echo Language::get('home.admin.clientip'); ?></strong>:</div> <?php echo $_SERVER['REMOTE_ADDR']; ?></span>
              <span class="sublabel"><div class="left"><strong><?php echo Language::get('home.admin.serveruptime'); ?></strong>:</div> <?php echo System::System_uptime(); ?></span>
            </div>

            <div class="clearfix visible-xs" style="padding-top:10px;"><hr /></div>

            <div class="col-sm-4" style>
              <h5 class="subtitle mb5"><?php echo Language::get('home.admin.serviceinfo'); ?></h5>
              <p class="mb15"><?php echo Language::get('home.admin.serviceinfo.desc'); ?></p>
              <span class="sublabel"><span>Apache:</span>  <div style="float: right; position: relative; left: -164px;"><?php echo(System::Check_process('apache2') === TRUE)? '<font color="green">'.Language::get('home.admin.online').'</font>' : '<font color="red">'.Language::get('home.admin.offline').'</font>'; ?></div></span>
              <span class="sublabel"><span>MySQL:</span>  <div style="float: right; position: relative; left: -164px;"><?php echo(System::Check_process('mysql') === TRUE)? '<font color="green">'.Language::get('home.admin.online').'</font>' : '<font color="red">'.Language::get('home.admin.offline').'</font>'; ?></div></span>
              <span class="sublabel"><span>POP/IMAP:</span>  <div style="float: right; position: relative; left: -164px;"><?php echo(System::Check_process('dovecot') === TRUE)? '<font color="green">'.Language::get('home.admin.online').'</font>' : '<font color="red">'.Language::get('home.admin.offline').'</font>'; ?></div></span>
              <span class="sublabel"><span>Postfix:</span>  <div style="float: right; position: relative; left: -164px;"><?php echo(System::Check_process('postfix') === TRUE)? '<font color="green">'.Language::get('home.admin.online').'</font>' : '<font color="red">'.Language::get('home.admin.offline').'</font>'; ?></div></span>
              <span class="sublabel"><span>ProFTP:</span>  <div style="float: right; position: relative; left: -164px;"><?php echo(System::Check_process('proftpd') === TRUE)? '<font color="green">'.Language::get('home.admin.online').'</font>' : '<font color="red">'.Language::get('home.admin.offline').'</font>'; ?></div></span>
            </div>

          </div>
        </div>
      </div>
    </div>


    <div class="col-sm-6 col-md-6">

      <div id="updatemessage" style="display:none;">
        <div class="alert alert-info">
          <?php echo Language::get('home.popup.update'); ?>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">

            <!-- col-sm-8 -->
            <div class="col-sm-12">
              <h5 class="subtitle mb5"><?php echo Language::get('home.dashboard.newsandanouncements'); ?></h5>
              <p class="mb15"><?php echo Language::get('home.dashboard.newsandanouncements.desc'); ?></p>

              <table class="table table-hover mb30">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                 <?php
                 $feedUrl = 'http://loreji.com/forum/extern.php?action=feed&fid=1&type=xml&time='.time();
                 $rawFeed = file_get_contents($feedUrl);
                 $xml = new SimpleXmlElement($rawFeed);
                 foreach ($xml->topic as $value) {
                  echo '<tr><td><a href="'.$value->link.'" target="_BLANK">'.$value->title.'</a></td><td>'.date('d-m-Y', strtotime($value->posted)).'</td></tr>';
                }
                ?>
              </tbody>
            </table>

            <!-- col-sm-4 --> 
          </div>
          

        </div>
      </div>
    </div>

  </div>



    <div class="col-sm-6 col-md-6">

<div class="panel panel-default">
        <div class="panel-body">
          <div class="row">

            <style type="text/css">

              .usage-block col-md-6 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-4 col-xs-offset-2 {
                position: relative;
                float: left;
                padding-right: 30px;
              }

            </style>

            <!-- col-sm-8 -->
            <div class="col-sm-12">
              <h5 class="subtitle mb5"><?php echo Language::get('home.dashboard.usage'); ?></h5>
              <p class="mb15"><?php echo Language::get('home.dashboard.usage.desc'); ?></p>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
              <?php
                $domain_array = Counter::get_domains();
              ?>
              <span>Domeinen (<?php echo $domain_array['used']; ?>/<?php echo $domain_array['total']; ?>)</span>
              <div style="width: 100px; heigth: 100px;" id="myStat" data-dimension="150" data-text="<?php echo $domain_array['percentage'];?>%"
              data-width="20" data-fontsize="25" data-percent="<?php echo $domain_array['percentage'];?>" data-fgcolor="#1CAF9A" 
              data-bgcolor="#eee" data-fill="#ddd" data-total="100" data-part="<?php echo $domain_array['percentage'];?>" 
              data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
              <?php
                $subdomain_array = Counter::get_sub_domains();
              ?>
              <span>Sub-Domeinen (<?php echo $subdomain_array['used']; ?>/<?php echo $subdomain_array['total'] ?>)</span>
              <div style="width: 100px; heigth: 100px;" id="myStat1" data-dimension="150" data-text="<?php echo $subdomain_array['percentage'];?>%"
              data-width="20" data-fontsize="25" data-percent="<?php echo $subdomain_array['percentage'];?>" data-fgcolor="#1CAF9A" 
              data-bgcolor="#eee" data-fill="#ddd" data-total="200" data-part="<?php echo $subdomain_array['percentage'];?>" 
              data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
              <?php
                $database_array = Counter::get_databases();
              ?>
              <span>Databases (<?php echo $database_array['used']; ?>/<?php echo $database_array['total'] ?>)</span>
              <div style="width: 100px; heigth: 100px;" id="myStat2" data-dimension="150" data-text="<?php echo $database_array['percentage'];?>%"
              data-width="20" data-fontsize="25" data-percent="<?php echo $database_array['percentage'];?>" data-fgcolor="#1CAF9A" 
              data-bgcolor="#eee" data-fill="#ddd" data-total="200" data-part="<?php echo $database_array['percentage'];?>" 
              data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
            <span>FTP Accounts (10/99)</span>
            <div style="width: 100px; heigth: 100px;" id="myStat3" data-dimension="150" data-text="35%"
            data-width="20" data-fontsize="25" data-percent="35" data-fgcolor="#1CAF9A" 
            data-bgcolor="#eee" data-fill="#ddd" data-total="200" data-part="35" 
            data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
            <span>Mailboxes (10/99)</span>
            <div style="width: 100px; heigth: 100px;" id="myStat4" data-dimension="150" data-text="35%"
            data-width="20" data-fontsize="25" data-percent="35" data-fgcolor="#1CAF9A" 
            data-bgcolor="#eee" data-fill="#ddd" data-total="200" data-part="35" 
            data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
            <span>Aliasses (10/99)</span>
            <div style="width: 100px; heigth: 100px;" id="myStat5" data-dimension="150" data-text="35%"
            data-width="20" data-fontsize="25" data-percent="35" data-fgcolor="#1CAF9A" 
            data-bgcolor="#eee" data-fill="#ddd" data-total="200" data-part="35" 
            data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
            <span>Schijfgebruik (10/99)</span>
            <div style="width: 100px; heigth: 100px;" id="myStat6" data-dimension="150" data-text="35%"
            data-width="20" data-fontsize="25" data-percent="35" data-fgcolor="#1CAF9A" 
            data-bgcolor="#eee" data-fill="#ddd" data-total="200" data-part="35" 
            data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>

            <div class="usage-block col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12 col-xs-offset-2">
            <span>Dataverkeer (10/99)</span>
            <div style="width: 100px; heigth: 100px;" id="myStat7" data-dimension="150" data-text="35%"
            data-width="20" data-fontsize="25" data-percent="35" data-fgcolor="#1CAF9A" 
            data-bgcolor="#eee" data-fill="#ddd" data-total="200" data-part="35" 
            data-icon="long-arrow-up" data-icon-size="28" data-icon-color="#fff"></div>
            </div>



            <!-- col-sm-4 --> 
          </div>
          

        </div>
      </div>
    </div> 

  </div> 

</div>
</div>
