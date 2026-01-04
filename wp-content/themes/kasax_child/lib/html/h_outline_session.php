<?php
  /**
  *介入型Outline
  */

  $s = NULL;
  $s2 = NULL;
  $s3 = NULL;
  $s4 = NULL;
  $s5 = NULL;

  $_count_ARR = 0;
  foreach( $this->kxol_Array_SESSION as $_valum ):

    if( !empty($_valum[ 'h_x' ] ) &&  $_valum[ 'h_x' ] == 2 )
    {
      $_count_ARR++;
    }

  endforeach;

  //echo $_count_ARR;

  if( $_count_ARR >= 10 )
  {
    $_sprintf_on = 1;
  }
  else
  {
    $_sprintf_on = 0;
  }
  //echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>


<!-- Index_main -->

    <ol style="list-style-type:none;  margin:0px 0 0px 0px;">
    <!-- <ol style="list-style-type:  decimal;margin:0px 0 0px 0px;">  -->

      <?php
        $s2 = -1;
        $s3 = 0;
      ?>

      <?php foreach( $this->kxol_Array_SESSION as $key	=> $value): ?>

        <?php
          if( !empty( $value[ 'h_x'] ) && !empty( $value[ 'h' . $value[ 'h_x'] ] ) )
          {
            $_heading_count = $value[ 'h_x' ] . '_' . $value[ 'h' . $value[ 'h_x'] ];
          }
          else
          {
            $_heading_count =  $key; //旧
          }

          $_daimei_js_target_title = NULL;

          if( !empty( $value[ 'daimei0'] ) )
          {
            $_daimei_js_target_title = $value[ 'daimei0'];
          }
          elseif( !empty( $value['daimei'] ) )
          {
            $_daimei_js_target_title = $value[ 'daimei'];
          }
        ?>

        <li style="margin:0px 0px;">
          <?php

            if( !empty($this->kxolS0['sys']) && $this->kxolS0['sys'] == 'URL_ON')
            {
              //テンプレート用。主にWorklist。

              $url = get_permalink( $this->kxolS1[ 'id' ] );
            }
            elseif(!preg_match ('/(p|page_id)='. $this->kxolS1[ 'id' ] .'/' , $_SERVER["REQUEST_URI"]  ) )
            {
              //羅列DB系で下記パターンがスルーされる。故に追記。2022/06/10

              $url = get_permalink( $this->kxolS1[ 'id' ] );

            }
            elseif( $this->kxolS1[ 'id' ] == get_the_ID() )
            {
              //print_r( $this->kxolS1);
              //echo $this->kxolS1[ 'id' ];
              //スクリプトが起動しなくなる。2022-01-29
              $url = NULL;
            }
            else
            {
              $url = get_permalink( $this->kxolS1[ 'id' ] );
            }

          ?>

          <a href="<?php echo $url; ?>#kxanchor<?php echo $_heading_count ?>">

            <?php
              if( !empty( $value['daimei'] ) && preg_match('/^★/' , $value['daimei']  ) )
              {
                $_class = '__a_red';
              }
              elseif( !empty( $value['daimei'] ) && preg_match('/^(▼|▲)/' , $value['daimei']  )  )
              {
                $_class = '__a_150';
              }
              elseif( !empty( $value['daimei'] ) && preg_match('/^▽/' , $value['daimei']  )  )
              {

                $_class = '__a_300';
              }
              elseif( !empty( $value['daimei'] ) && preg_match('/^☆/' , $value['daimei']  )  )
              {

                //$_class = '__color_normal';
                $_class = '__a_violet_kx';

              }
              else
              {

                unset( $_class );

              }


              if( !empty( $value['daimei'] ) && preg_match( '/🟥|🟦|🟩|🟨/' ,$value['daimei']  , $matches ) )
              {
                $_color_on = 1;

                if( empty( $value[ 'h_x' ] ))
                {
                  $value[ 'h_x' ] = NULL;
                }

                if( $matches[0] == '🟥' && $value[ 'h_x' ]  ==  2 ):

                  //$_bg  = 'background-color:	hsla(	330	,	100%	,50%	,.5);';
                  $_hsla   = '330	,	100%	,50%	,.3';
                  $_hsla_B = '330';

                elseif( $matches[0] == '🟦' && $value[ 'h_x' ]  ==  2 ):

                  //$_bg ='background-color:	hsla(	240	,	100%	,50%	,.5);';
                  $_hsla   = '240	,	100%	,50%	,.5';
                  $_hsla_B = '240';

                elseif( $matches[0] == '🟩' && $value[ 'h_x' ]  ==  2 ):

                  $_hsla   = '150	,	100%	,50%	,.3';
                  $_hsla_B = '150';

                elseif( $matches[0] == '🟨' && $value[ 'h_x' ]  ==  2 ):

                  $_hsla   = '45	,	100%	,50%	,.3';
                  $_hsla_B = '45';

                endif;

                if( !empty( $value[ 'h_x' ] ) && $value[ 'h_x' ] == 2 )
                {

                  $_bg   = 'border:solid 3px hsla( '.$_hsla.');';
                  $_bg  .= 'background-color:hsla( '.$_hsla_B.' , 100%	, 50%	,.1 );';
                }
                else
                {
                  $_bg  = 'background-color:	hsla(	'.$_hsla.');color:white;';
                }

                $_style_A = $_bg . 'padding:0 0 0 3px;color:white;border-radius: 5px;';//border-radius: 20px;

                $value[ 'daimei' ]  = str_replace( $matches , '' , $value['daimei'] );

              }
              else
              {
                unset( $_style_A );

                if(
                  empty( $_SESSION[ 'Heading_count' ][ $this->kxolS1[ 'id' ] ]['color_off'] )
                  &&  empty( $_color_on )
                  && !empty( $title_base )
                  &&  preg_match( '/(∬\d{1,}≫c\d\w{1,}\d)(?!.*来歴)/' , $title_base )
                ):

                  $_color_on = 1;

                endif;

                //echo $value['haeding_plot_on'].' - '.$value['daimei'];

                if( !empty( $value['haeding_plot_on'] ) )
                {
                  $_color_on  = 1;
                }

                if( !empty( $_color_on ) )
                {


                  if( !empty( $value['haeding_plot_on'] ) )
                  {
                    if( $value['haeding_plot_on'] == '1')
                    {
                      $_hsla = '0	,	100%	,50%	,.3';
                      $_hsla_B = '0	,	100%	,50%	,.1';
                    }
                    elseif( $value['haeding_plot_on'] == '2')
                    {
                      $_hsla = '210	,	100%	,50%	,.3';
                      $_hsla_B = '210	,	100%	,50%	,.1';
                    }
                    elseif( $value['haeding_plot_on'] == '3')
                    {
                      $_hsla = '150	,	100%	,50%	,.3';
                      $_hsla_B = '150	,	100%	,50%	,.1';
                    }
                    elseif( $value['haeding_plot_on'] == '4')
                    {
                      $_hsla = '300	,	100%	,50%	,.3';
                      $_hsla_B = '300	,	100%	,50%	,.1';
                    }
                    elseif( $value['haeding_plot_on'] == '5')
                    {
                      $_hsla = '180	,	100%	,50%	,.3';
                      $_hsla_B = '180	,	100%	,50%	,.1';
                    }
                    elseif( $value['haeding_plot_on'] == '6')
                    {
                      $_hsla = '120	,	100%	,50%	,.3';
                      $_hsla_B = '120	,	100%	,50%	,.1';
                    }
                  }
                  elseif( preg_match( '/('	.	KxSu::get('titile_search')[	'work_Platform'	]	.	')$/i' , $value['daimei'] , $matches1 ) && $value[ 'h_x' ]  == 2 )
                  {

                    $_color_on_series = 1;

                    if( $matches1[1] == 'Ksy')
                    {
                      $_hsla = '180	,	100%	,50%	,.3';
                    }
                    elseif( $matches1[1] == 'Ygs')
                    {
                      $_hsla = '300	,	100%	,50%	,.3';
                    }

                  }
                  elseif( empty( $_color_on_series ) )
                  {
                    if( $value[ 'h_x' ]  !=  2 )
                    {
                      unset($_color_on_series );
                    }

                    $_hsla   = '120	,	100%	,50%	,.1';
                    $_hsla_B = '120	,	100%	,50%	,.02';
                  }
                  unset( $matches1 );

                  if( !empty( $value[ 'h_x' ] ) && $value[ 'h_x' ]  ==  2 )
                  {
                    $_bg     = 'border:solid 3px hsla( '.$_hsla.' );';
                    $_bg    .= 'background-color:hsla( '.$_hsla_B.' );';
                  }
                  else
                  {
                    $_bg     = 'background-color:	hsla(	'.$_hsla.');color:white;';
                  }

                  $_style_A  = $_bg.'border-radius: 5px;';//丸みを追加。プロット系で利用。2023-06-30
                  $_style_0 = $_style_A;
                }
              }
              unset( $matches );


              if( empty( $_style_A ) )
              {
                $_style_A = NULL;
              }

              $_style_A  .= 'padding:0 3px 0 3px;';

              if( !empty( $value[ 'h_x' ] ) && $value[ 'h_x' ]  ==  2 )
              {

                $s2++;
                $s3 = NULL;
                $s4 = NULL;
                $s5 = NULL;

                if( !empty( $_color_on ) )
                {
                  $_style_0   = 'border-radius: 10px;line-height:1.2; margin:2px 0 0 0px; padding:0px 10px 0px 3px;'.$_bg;
                  unset( $_style_A );
                  $_style_A  = NULL;
                  $_style_A  .= 'border-radius:5px 0px 0px 5px; ';
                  $_style_A  .= 'background-color:hsla(	'.$_hsla.');';
                  $_style_A  .= 'margin:0 0 0 -5px;';
                  $_style_A  .= 'padding:3px 8px 3px 5px;'; //押し上げる
                  $_style_A  .= 'color:white;';
                }
                else
                {
                  $_style_0 = 'margin:0px 0 0 0px;';
                }

                $_count  = $s2;
              }
              elseif( !empty( $value[ 'h_x' ] ) && $value[ 'h_x' ]  ==  3 )
              {

                /*
                if( $s2 == -1):
                  $s2 = 0;
                  //理由不明バグの対応処置。2022/04/18。
                endif;
                */

                $s3++;
                $s4 = NULL;
                $s5 = NULL;

                if( !empty( $_color_on ) )
                {
                  $_style_0 = 'margin-left:8px;';
                }
                else
                {
                  $_style_0  = 'margin-left:4px;';
                  $_style_0 .= 'border-left:double 5px hsla(0 , 0% ,50% ,.15	);padding-left:2px;';
                }

                $_count  = (int)$s2.'.'.(int)$s3;
              }
              elseif( !empty( $value[ 'h_x' ] ) && $value[ 'h_x' ]  ==  4)
              {
                $s4++;
                $s5 = NULL;

                if( !empty( $_color_on ) )
                {
                  $_style_0 = 'margin-left:16px;';
                }
                else
                {
                  $_style_0 = 'margin-left:4px;';
                  $_style_0 .= 'border-left:double 5px hsla(0 , 0% ,50% ,.1	);padding-left:2px;';
                  $_style_0 .= 'padding-left:12px';
                }

                $_count  = (int)$s2.'.'.(int)$s3.'.'.(int)$s4;
              }
              elseif( !empty( $value[ 'h_x' ] ) &&$value[ 'h_x' ]  ==  5 )
              {
                $s5++;
                //echo '<div style="margin:0 24px;">'.(int)$s2.'.'.(int)$s3.'.'.(int)$s4.'.'.(int)$s5.' ';

                if( !empty( $_color_on ) )
                {
                  $_style_0 = 'margin-left:24px;';
                }
                else
                {
                  $_style_0 = 'margin-left:4px;';
                  $_style_0 .= 'border-left:double 5px hsla(0 , 0% ,50% ,.08	);padding-left:2px;';
                  $_style_0 .= 'padding-left:20px';
                }

                $_count  = (int)$s2 . '.' . (int)$s3 . '.' . (int)$s4 . '.' . (int)$s5;
              }
              elseif( !empty( $value[ 'h_x' ] ) && $value[ 'h_x' ]  ==  6 )
              {
                $_style_0 = 'margin-left:30px;';
                $_count  = 'ⅵ+';
              }
              else
              {
                if( empty( $value[ 'h_x' ] ) )
                {
                  $value[ 'h_x' ] = NULL;
                }

                $_style_0 = 'margin-left:0px;';
                $_count  = $value[ 'h_x' ].'ERROR.'.$key;
              }
            ?>

            <?php
              //なぜか読み込まれてしまう。2022-01-24
              if( empty( $_class ))
              {
                $_class = NULL;
              }

              if( empty( $_style_0_add ))
              {
                $_style_0_add = NULL;
              }
            ?>



            <div class="<?php echo $_class; ?>" style="white-space: nowrap;<?php echo $_style_0.$_style_0_add; ?>">

              <span style="margin:0 3px 0 0 ; padding:2px 3px ; display:inline-block;<?php echo $_style_A; ?>;">

                <?php
                  //$_count = $_count - 1;

                  if( $_sprintf_on && $value[ 'h_x'] == 2 )
                  {
                    echo  sprintf('%02d', $_count);
                  }
                  else
                  {
                    echo  $_count;
                  }
                ?>

              </span>

              <?php
                if( empty( $value['id_js'] ))
                {
                  $value['id_js'] = NULL;
                }

                if( empty( $value[ 'daimei_add' ] ) )
                {
                  $value[ 'daimei_add' ] = NULL;
                }

                if( empty( $value[ 'daimei' ] ) )
                {
                  $value[ 'daimei' ] = NULL;
                }
              ?>

              <span class="js_target_title<?php echo $value['id_js'].'_'.$_daimei_js_target_title;?>">
                <?php echo $value[ 'daimei_add' ]; ?>
                <?php echo kx_change_outline_title( $value[ 'daimei' ] , 'outline_text' ); ?>
              </spna>
            </div>
          </a>
        </li>

      <?php endforeach; ?>

    <ol>

<!-- インディックスmain -->

