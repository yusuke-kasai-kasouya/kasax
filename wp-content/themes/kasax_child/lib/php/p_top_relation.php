<?php

  require_once ('../../../../../wp-blog-header.php');

  //メインプログラム
  $_top_relation           = new kxTpr;
  $_top_relation->kxTpr_S0[ 'id'] = $_GET[ 'id' ];

  //配列として出力。下記にhtmlを記載。
  $_top_relation->kxTpr_Main();

  $_arr = $_top_relation->kxTpr_contents;


/**
 * headerの〓の部分。
 *
 * スクリプト表示。シンプルタイプ。
 * idのみ来ている。
 */
class kxTpr {

  //入力設定
  public $kxTpr_S0;

  //設定
  public $kxTpr_S1;

  public $kxc;

  public $kxTpr_contents;

  /**
   * メインプログラム
   * 配列を出力する。
   * 2023-06-17
   *
   * @param [type] $id
   * @return void
   */
  public function kxTpr_Main(){
    //設定作成
    $this->kxTpr_setting1();

    //スタイル（style）を作成。2023-06-17
    $this->kxTpr_style_css();

    //TODO作成
    //$this->kxTpr_Todo();

    //タイトル系
    $this->kxTpr_contents[ 'title' ]  = $this->kxTpr_S1[ 'title' ];
    $this->kxTpr_contents[ 'title1' ] = $this->kxTpr_S1[ 'title1' ];
  }



  /**
   * 旧メインプログラム
   * セッティング関数に置換中。2023-06-17
   *
   * @param int $id
   * @return void
   */
  public function kxTpr_setting1(){

    $this->kxTpr_S1 = $this->kxTpr_S0;

    $id = $this->kxTpr_S1[ 'id'];

    $_SyncType = NULL;
    $_SyncCategory = NULL;

    $_SESSION[ 'add_new' ]	=1399;

    $this->kxTpr_S1[ 'title' ]      = get_the_title( $id );
    $this->kxTpr_S1[ 'title1' ]     = mb_substr($this->kxTpr_S1[ 'title' ] , 0,1);  //1文字目
    $this->kxTpr_S1[ 'title_base' ] = NULL;

    $str = NULL;

    if(preg_match( '/∬\d{1,}≫c\d\w{1,}\d/' , $this->kxTpr_S1[ 'title' ] , $matches))
    {
      $this->kxTpr_S1[ 'title_base' ] = $matches[0];
    }
    unset( $matches );

    $post = get_post( $this->kxTpr_S1[ 'id'] );
    $post_content = $post->post_content;

    $this->kxTpr_S1[ 'type2' ] = NULL;
    $this->kxTpr_S1[ 'type3' ] = NULL;

    $str = NULL;

    if( preg_match( '/\[raretu(.*|)\]/' , $post_content ) || preg_match('/\[.*type=list_DB.*\]/' , $post_content ) )
    {
      //raretuタイプ

      $this->kxTpr_S1[ 'type2' ]  = 'raretu';

      $str .= $this->kxTpr_raretu();
    }
    elseif(  preg_match('/\[kx_tp.*\]/'  , $post_content , $matches ) )
    {
      //テンプレートタイプ

      if( preg_match( '/type=chara/i'  , $matches[0] ) )
      {
        //キャラの場合。

        $this->kxTpr_S1[ 'type3' ]  = '：chara';

      }
      elseif( preg_match( '/type=k2/i'  , $matches[0] ) )
      {
        $this->kxTpr_S1[ 'type3' ]  = '：k2';
      }
      elseif( preg_match( '/type=k3/i'  , $matches[0] ) )
      {
        $this->kxTpr_S1[ 'type3' ]  = '：k3';
      }

      $this->kxP_top_relation_Content_kxtp( $matches , $post_content );
    }




    //教訓
    if( $this->kxTpr_S1[ 'title1' ]  ==  '∬' && $this->kxTpr_S1[ 'type2' ] != 'raretu' )
    {
      if( preg_match( '/∬\d{1,}≫c\d\w{1,}\d≫2構成$/' ,  $this->kxTpr_S1[ 'title' ] ) )
      {
        //K2。2構成の場合。2023-03-01

        $this->kxTpr_S1[ 'type2' ]  = '2構成';

        //教訓K2
        $search = 'W'.str_replace(	'∬'	,''	,$this->kxTpr_S1[ 'kxtt' ]['world']	)	.'＞c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ];
        $str .= $this->kxP_top_relation_kyoukun( $search , 'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] ,  'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] );

        //$str  .=  $charas;

        $str  .= '<div style="margin:20px 0 0 0;"><h6>関連</h6>';

        $str	.=   kx_CLASS_kxx( [

          'text_c'        =>  'リスト・2構成',
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ].'≫2構成≫リスト',
          'title_s'				=>	'リスト＄',
          'new_content'  =>  '＿kx_tp type＝list_chara_pickup＿',

        ] );

        $str	.=  $this->kxTpr_S1[ 'list_k2' ];
        $str	.=  $this->kxTpr_S1[ 'kikaku' ];
        $str  .=  $this->kxTpr_S1[ 'list_arr' ];
      }
      elseif( $this->kxTpr_S1[ 'type3' ]  == '：k3' )
      {
        //K3
        $this->kxTpr_S1[ 'type2' ]  = '3構成';

        $search = 'W'.str_replace(	'∬'	,''	,$this->kxTpr_S1[ 'kxtt' ]['world']	)	.'≫'.$this->kxTpr_S1[ 'kxtt' ][ 'work_code_top3' ] . $this->kxTpr_S1[ 'kxtt' ][ 'work_code_number' ];
        $str  .=  $this->kxP_top_relation_kyoukun( $search , $this->kxTpr_S1[ 'kxtt' ][ 'work_code' ] );

        $str  .=  '<div>';
        $str  .=  $this->kxTpr_S1[ 'kousei2' ];
        $str	.=  $this->kxTpr_S1[ 'raireki' ];


        //$str  .= '<h6>一覧</h6>';

        /*
        $str	.=   '<h6>キャラ要素リストアップα</h6>'.kx_CLASS_kxx( [

          'text_c'				=>	'リスト・2構成',
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	'≫' . $this->kxTpr_S1[ 'kxtt' ][ 'work_code' ] . '≫',
          'title_s'				=>	'リスト＄',
          'new_content'	=>	'＿kx_tp type＝list_k3＿',

        ] );
        */

        $str	.=  $this->kxTpr_S1[ 'list_k2' ];
        $str  .=  $this->kxTpr_S1[ 'list_arr' ];
        //$str  .=  $this->kxTpr_S1[ 'k3_raretu' ];
        //$str  .=  $this->kxTpr_S1[ 'k3_raretu_maru' ];

        $str  .= '<h6>来歴対人</h6>';

        //■対人リスト
        $str	.=   kx_CLASS_kxx(
        [
          't'							=>	96,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	'＼',
          'title_s'				=>	'来歴＄',
          'sys'				=>	'new_off',
        ] );

        $search = 'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] . '≫' . $this->kxTpr_S1[ 'kxtt' ][ 'work_code' ];
        $str .= $this->kxP_top_relation_FolderLIST( $this->kxTpr_S1[ 'cat_end' ] ,'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] ,$search );

        $str  .= '</div>';
      }
      elseif( $this->kxTpr_S1[ 'type3' ]  == '：chara' )
      {
        //キャラクター

        $this->kxTpr_S1[ 'type2' ]  = 'キャラ設定';



        $_k_num = 'c'. $this->kxTpr_S1[ 'kxtt' ][ 'character_number' ];
        $_k_search = 'W'.str_replace(	'∬'	,''	,$this->kxTpr_S1[ 'kxtt' ]['world']	)	.'≫c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ];

        $str .= $this->kxP_top_relation_kyoukun($_k_search ,'',$_k_num);


        if( !empty( $this->kxTpr_S1[ 'BigStory' ] ))
        {
          $str	.=  $this->kxTpr_S1[ 'kousei1' ];
        }
        elseif( empty( $this->kxTpr_S1[ 'ShortStory' ] ))
        {
          $str	.=  $this->kxTpr_S1[ 'kousei2' ];
        }

        $str	.=  $this->kxTpr_S1[ 'raireki' ];

        /*
        $str	.=   '<h6>キャラ要素リストアップβ</h6>'.kx_CLASS_kxx( [

          'text_c'				=>	'リスト・3構成',
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ].'≫2構成≫',
          'title_s'				=>	'リスト＄',
          'new_content'	=>	'＿kx_tp type＝list_k3＿',

        ] );
        */


        $str	.=  $this->kxTpr_S1[ 'list_k2' ];
        $str	.=  $this->kxTpr_S1[ 'kikaku' ];
        $str  .= $this->kxTpr_S1[ 'list_arr' ];

      }
      else
      {

        $this->kxTpr_S1[ 'type2' ]  = 'ETC';

      }
    }


    //echo  '<div class="__relation2">'.$ret.'</div>';
    $_SyncType_arr = [

      //'制作'		=>[      '/^∬/'    ],

      '題材'		=>[
        '/^∮≫題材/',
        [''],
      ],

      '制作・キャラパターン'		=>[
        '/^∫≫登場人物/',
        [''],
      ],

      'δ3'		=>[
        '/^(γ|Β|σ|δ)/',
        [ 'γ'=>[65,'感性'] , 'σ'=>[65,'研究'] , 'δ'=>[65,'資料'] ]
      ],

      'δ4'		=>[
        '/^(γ|Β|σ|δ)≫(芸術・制作|医学)/',
        [ 'γ'=>[65,'感性'] , 'Β'=>[65,'教訓'], 'σ'=>[65,'研究'] , 'δ'=>[65,'資料']  ],
      ],

      'δ5'		=>[
        '/^(γ|Β|σ|δ).*芸術・作品≫分類/',
        [ '題材参照'=>[65] , 'γ'=>[65,'感性'] , 'Β'=>[65,'教訓'], 'σ'=>[65,'研究'] , 'δ'=>[65,'資料'] ],
      ],

      'なし'		=>[
        '/^Β≫芸術・制作≫戦略≫作品|∬/',
        [],
      ],

    ];

    foreach( $_SyncType_arr as $key => $value ):

      if( preg_match( $value[0] , $this->kxTpr_S1[ 'title' ] ) )
      {
        $_SyncType = $key;
      }

    endforeach;
    unset( $key , $value );


    if( !empty( $_SyncType ) )
    {

      foreach( $_SyncType_arr[ $_SyncType ][1] as $key => $value ):

        $cat = NULL;
        if( $_SyncType ==  '題材'  )
        {

          $search = 'σ≫芸術・作品≫分類≫'.preg_replace( '/∮≫題材≫/', '' , $this->kxTpr_S1[ 'title' ]  );
          $t            = 19;
          $cat					= 54; //332
        }
        elseif( $_SyncType == '制作・キャラパターン'  )
        {

          $t            = 19;
          $cat					= 41;
          $search = '芸術・作品≫登場人物';
        }
        elseif( $key == '題材参照' )
        {

          $t            = $value[0];
          $cat					= 325;
          $search = '∮'.preg_replace( '/' .$this->kxTpr_S1[ 'title1' ]. '≫芸術・作品≫分類/', '' , $this->kxTpr_S1[ 'title' ]  );//≫題材
        }
        elseif( $this->kxTpr_S1[ 'title1' ] !=  $key )
        {

          $t            = $value[0];
          $search = preg_replace( '/' .$this->kxTpr_S1[ 'title1' ]. '/', $key  , $this->kxTpr_S1[ 'title' ]  );
        }


        if( !empty( $search ) )
        {
          $sys = NULL;
          if( is_array( $value ))
          {
            if( !empty( $value ['sys' ] ) )
            {
              $sys = $value ['sys' ];
            }
          }

          if( !empty( $value[1]))
          {
            $_title = $key.$value[1];
          }
          else
          {
            $_title = $key;
          }


          $_SyncCategory .= '<div><div style="display: inline-block";>'.$_title . '</div><div style="display: inline-block";>';

          $_SyncCategory .= kx_CLASS_kxx(
          [
            't'							=> $t,
            'cat'						=> $cat,
            'search'				=> $search,
            'title_s'				=> $search.'＄',
            //'text_c'				=> $text_c,
            'new_title'			=> $search,
            'sys'           => $sys,
          ] );
          $_SyncCategory .= '</div></div>';

          unset( $search , $cat );

        }

      endforeach;
      unset( $key , $value );

    }

    $this->kxTpr_contents[ 'type2' ]        = $this->kxTpr_S1[ 'type2' ];
    $this->kxTpr_contents[ 'type3' ]        = $this->kxTpr_S1[ 'type3' ];
    $this->kxTpr_contents[ 'SyncType' ]     = $_SyncType;
    $this->kxTpr_contents[ 'SyncCategory' ] = $_SyncCategory;
    $this->kxTpr_contents[ 'str' ]          = $str;
  }



  /**
   * スタイル作成
   *
   * @return void
   */
  public function kxTpr_style_css(){

    $style_css   =  '<style type="text/css">';
    $style_css  .=  '<!-- ';
    $style_css  .=  '::-webkit-scrollbar{ width:7px;}';
    $style_css  .=  ' -->';
    $style_css  .=  '</style>';

    $this->kxTpr_contents[ 'style_css' ] = $style_css;
  }


  /**
   * raretu用。
   * 2023-06-29
   *
   * @return void
   */
  public function kxTpr_raretu(){

    $_title_end  = end( explode( '≫' , $this->kxTpr_S1[ 'title' ] ) );

    $_tags  = get_the_tags( $this->kxTpr_S1[ 'id'] );

    //タグ関連
    $_tag = NULL;
    if( is_array( $_tags ) )
    {
      $i=0;
      foreach( $_tags as $_tag ):
        //echo'+'.$_tag->name.$_title_end;

        $_tag_name = $_tag->name;

        if( $i == 0 )
        {
          $_tag_str = $_tag_name;
        }
        else
        {
          $_tag_str .= ' ' . $_tag_name;
        }

        $i++;

        $_tag = '"' . $_tag_str . '"';

        //echo $_tag->name;

        if( $_tag_name == $_title_end )
        {
          $_arr[ 'update_check' ] = kx_update_cat_check(
          [
            'type'    => 'tagCheck',
            'tag_not' =>  $_title_end,
            'search'  =>  $_title_end,
          ] );
        }

      endforeach;
    }

    $cat_arr  = kx_get_category( $this->kxTpr_S1[ 'id'] );
    //$cat_top  = $cat_arr[ 'cat_top' ];
    $this->kxTpr_S1[ 'cat_end' ]  = $cat_arr[ 'cat_end' ];


    $str = NULL;

    if( $this->kxTpr_S1[ 'title' ] == get_cat_name( $this->kxTpr_S1[ 'cat_end' ] ) )
    {
      $str .= '<h6>管理ファイル</h6>';

      $str	.=   kx_CLASS_kxx( [

        't'							=>	65,
        'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
        'search'				=>	$this->kxTpr_S1[ 'title' ].'$',
        'new_content'  =>  '＿kx_tp type＝menu check_update＝0＿',
        'new_title'     =>  $this->kxTpr_S1[ 'title' ],
        'post_type'     =>  'page',

      ] );

      $str .= '<hr>';
    }


    $_add_search= NULL;
    if( !preg_match( '/≫/' , $this->kxTpr_S1[ 'title' ] ) )
    {
      //$_add_search  = ' -≫.*≫.*≫';
      //$_list_all_h6 = '（上位・縮小型）「-≫.*≫.*≫」';
      $_list_all_h6 = '（TOP）';
    }
    else
    {
      $_list_all_h6 = '（NORMAL）';
    }

    $str .= '<h6>raretu-LIST' . $_list_all_h6 . '</h6>';

    //スペース飛ばし
    $_title_s = preg_replace( '/^.* /' , '' , $this->kxTpr_S1[ 'title' ] );

    //$str	.=   $this->kxTpr_S1[ 'title' ] ;
    $str	.=  kx_db_Hierarchy_render_ui($this->kxTpr_S1[ 'title' ] );

    /*
    $str	.=   kx_CLASS_kxx( [

      't'							=>	90,
      'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
      'tag'           =>  $_tag,
      'search'				=>	$this->kxTpr_S1[ 'title' ] . $_add_search ,
      //'title_s'       =>  '-' . $this->kxTpr_S1[ 'title' ] . '.*≫.*≫.*≫',
      //'title_s'       =>  '-' . $_title_s . '.*≫.*≫.*≫',  //一時的に機能削除。2023-03-04
      'sys'           =>  'raretu_check',
      'ppp'           =>  '500',

    ] );
     */

    return $str;
  }


  /**
   * TODO作成。
   * 2023-06-17
   *
   * @return void
   */
  /*
  public function kxTpr_Todo(){
    //TODOメモ
    $this->kxTpr_contents[ 'todo' ] = kx_CLASS_kxx( [

      't'		=>	17,
      'id'	=>	3,

    ]	);

    //$this->kxTpr_contents[ 'todo' ]         = $this->kxTpr_S1[ 'todo' ];
  }
    */


  /**
   * 教訓関数。2025-03-24
   * 制作作品の教訓。
   *
   * @param [type] $search
   * @param [type] $text_c
   * @param [type] $_tag
   * @return void
   */
  public function kxP_top_relation_kyoukun( $search ,  $text_c = null , $_tag = null	) {

    $search = 'Β＞芸術・制作＞戦略＞作品＞' .$search;

    return '<h6>教訓</h6>'.kx_CLASS_kxx( [
      't'							=>	19 ,
      'cat'						=>	86 ,
      'tag'						=>	$_tag,
      'search'				=>	$search ,
      'text_c'				=>	$search .'$' ,
      'new_title'			=>	$search ,
      'text_c'				=>	'教訓：' . $text_c,
    ] );

  }


  /**
   * Undocumented function
   *
   * @param [type] $cat
   * @param [type] $_tag
   * @param [type] $search
   * @return void
   */
  public function kxP_top_relation_FolderLIST( $cat , $_tag , $search ){

    return '<h6>LIST</h6>' . kx_CLASS_kxx( [
      't'							=>	90 ,
      'cat'						=>	$cat ,
      'tag'						=>	$_tag,
      'search'				=>	$search ,
    ] );

  }



  /**
   * Undocumented function
   *
   * @param [type] $matches
   * @param [type] $post_content
   * @return void
   */
  public function kxP_top_relation_Content_kxtp( $matches , $post_content ){

    if( preg_match(	'/^∬(.*?)≫/'	,$this->kxTpr_S1[ 'title' ]	, $_matches_world_num ) )
    {
      $sakuhin_world_num	= $_matches_world_num[1];
      $sakuhin_world	    = '∬' . $_matches_world_num[1];
    }
    unset($_matches_world_num);

    if( preg_match( '/\[kx_tp.*c=(\d\w{1,}\d).*\]/' ,  $post_content  ,$matches_c ) )
    {
      $c = $matches_c[1];
    }
    else
    {
      $c  = '001';
    }


    if( !preg_match( '/\[kx_tp.*cs=(\d\w{1,}\d).*\]/' ,  $post_content  ,$matches_cs ) )
    {
      $matches_cs[1] = NULL;
    }


    $cs = $matches_cs[1];

    $cat_arr  = kx_get_category( $_GET[ 'id' ] );
    $cat_top  = $cat_arr[ 'cat_top' ];
    $this->kxTpr_S1[ 'cat_end' ]  = $cat_arr[ 'cat_end' ];

    $this->kxTpr_S1[ 'kxtt' ]	= kx_CLASS_kxTitle(
    [
      'type'  => 'work',
      'title' => $this->kxTpr_S1[ 'title' ],
    ]);

    if(
      !empty( $this->kxTpr_S1[ 'kxtt' ][ 'character_info' ] )
      && preg_match( '/ShortStorySystem/' , $this->kxTpr_S1[ 'kxtt' ][ 'character_info' ] )
    ){
      $this->kxTpr_S1[ 'ShortStory' ] = 1;
    }
    elseif(
      !empty( $this->kxTpr_S1[ 'kxtt' ][ 'character_info' ] )
      && preg_match( '/BigStorySystem/' , $this->kxTpr_S1[ 'kxtt' ][ 'character_info' ] )
    ){
      $this->kxTpr_S1[ 'BigStory' ] = 1;
    }

    //print_r(  $this->kxTpr_S1[ 'kxtt' ] );

    //echo '+++++';
    $str = NULL;

    if(
      $this->kxTpr_S1[ 'type3' ]  ==  '：k2' ||
      $this->kxTpr_S1[ 'type3' ]  ==  '：k3' ||
      $this->kxTpr_S1[ 'type3' ] ==  '：chara'
    )
    {
      preg_match( '/∬\d{1,}≫c\d\w{1,}\d/' , $this->kxTpr_S1[ 'title' ] , $matches );
      $this->kxTpr_S1[ 'title_base' ] = $matches[0];

      $charas  = '';

      if( empty(  $this->kxTpr_S1[ 'BigStory' ] ) ){
        $charas .= '<div style="margin:20px 0 0 0;"><h6>登場人物W</h6>';
        //キャラ
        $charas	.=   kx_CLASS_kxx(
        [
          't'             =>  65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ].'≫W',
          'title_s'				=>	'W＄',
          'text_c'				=>	'Chara-W',
          'new_content'	=>	'＿kx_tp type＝charaW＿',
          'new_title'	=>	$this->kxTpr_S1[ 'title_base' ]. '≫W',
        ] );
      }

      $charas  .= '</div>';
      $str .= $charas;

      $this->kxTpr_S1[ 'list_arr' ] = $str;
      $str = NULL;

      // 2構成
      $this->kxTpr_S1[ 'list_k2' ]   = '<h6>DB一覧</h6>';

      $this->kxTpr_S1[ 'list_k2' ] .= '<div style="margin:0 20px;">';
      $this->kxTpr_S1[ 'list_k2' ] .= '・<a style="color:aqua;display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_template.php?title='. $sakuhin_world .'≫c' . $this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] .'&type=list_chara_all">DB_ALL_LIST</a>';
      $this->kxTpr_S1[ 'list_k2' ] .= '<br>';
      $this->kxTpr_S1[ 'list_k2' ] .= '・<a style="color:aqua;display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_template.php?title='. $sakuhin_world .'≫c' . $this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] .'&type=list_raretu">DB_Raretu</a>';
      $this->kxTpr_S1[ 'list_k2' ] .= '<br>';
      $this->kxTpr_S1[ 'list_k2' ] .= '・<a style="color:aqua;display:inline-block;" href="wp-content/themes/kasax_child/lib/php/DB_template.php?title='. $sakuhin_world .'≫c' . $this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] .'&type=list_chara_maru">DB_〇LIST</a>';
      $this->kxTpr_S1[ 'list_k2' ] .= '</div>';
    }


    $this->kxTpr_S1[ 'kikaku' ] = '';

    if( $this->kxTpr_S1[ 'type3' ]  ==  '：k2' || $this->kxTpr_S1[ 'type3' ] ==  '：chara')
    {
      $this->kxTpr_S1[ 'kikaku' ]  .= '<div style="margin:20px 0 0 0;"><h6>企画</h6>';
      $this->kxTpr_S1[ 'kikaku' ]  .= kx_CLASS_kxx(
      [
        't'							=>	96,
        'cat'						=>	$cat_top,
        'tag'						=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
        'search'				=>	'≫',
        'title_s'				=>	'(Ygs|Olf|Ksy|Sys)\d{3,}$',
      ] );

      $this->kxTpr_S1[ 'kikaku' ]  .= kxEdit(
      [
        'new'						=>	1,
        'new_title'			=>	$sakuhin_world .'≫c' . $this->kxTpr_S1[ 'kxtt' ][ 'character_number' ].'≫Sys' . $sakuhin_world_num.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ].'001',
        'new_content'	=>	"＿kx_tp type＝k3 sys＝sys＿"  .	$sakuhin_world_num . '-' . $this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] . '-' . '001',
        //'css_hyouji'		=>	$css_hyouji,
        'hyouji'				=>	'＋企画',
      ] );

      $this->kxTpr_S1[ 'kikaku' ]  .= '</div>';
    }


    if( $this->kxTpr_S1[ 'type3' ]  ==  '：k3' || $this->kxTpr_S1[ 'type3' ] ==  '：chara')
    {
      if( !empty( $this->kxTpr_S1[ 'BigStory' ] ))
      {
        //1構成
        $this->kxTpr_S1[ 'kousei1' ]   = '<h6>1構成</h6>';
        $this->kxTpr_S1[ 'kousei1' ]	.=   kx_CLASS_kxx(
        [
          'text_c'				=>	"1構成",
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	'≫',
          'title_s'				=>	'1構成$',
          'new_content'  =>  '＿kx_tp type＝k1＿',
          'new_title'     =>  $this->kxTpr_S1[ 'title_base' ] . '≫1構成',
        ] );

        $this->kxTpr_S1[ 'kousei2' ] = NULL;
      }
      else
      {
        //2構成
        $this->kxTpr_S1[ 'kousei2' ]   = '<h6>2構成</h6>';
        $this->kxTpr_S1[ 'kousei2' ]	.=   kx_CLASS_kxx(
        [
          'text_c'				=>	"2構成",
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	'≫',
          'title_s'				=>	'2構成$',
          'new_content'  =>  '＿kx_tp type＝k2＿',
          'new_title'     =>  $this->kxTpr_S1[ 'title_base' ] . '≫2構成',
        ] );
      }

      $this->kxTpr_S1[ 'raireki' ]	=   kx_CLASS_kxx(
        [
          'text_c'				=>	"W",
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
          'search'				=>	'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] . '≫W',
          'title_s'				=>	'W＄ -＼',
          'new_content'  =>  '＿raretu＿',
          'new_title'     =>  $this->kxTpr_S1[ 'title_base' ] . '≫W',
        ] );

      //来歴
      $this->kxTpr_S1[ 'raireki' ]  .= '<h6>来歴</h6>';

      $this->kxTpr_S1[ 'raireki' ]	.=   kx_CLASS_kxx(
      [
        'text_c'				=>	"来歴　─　個人",
        't'							=>	65,
        'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
        'tag'						=>	'c'.	$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ],
        'search'				=>	'c'.$this->kxTpr_S1[ 'kxtt' ][ 'character_number' ] . '≫来',
        'title_s'				=>	'歴＄ -＼',
        'new_content'  =>  '＿raretu＿',
        'new_title'     =>  $this->kxTpr_S1[ 'title_base' ] . '≫来歴',
      ] );

      if( $this->kxTpr_S1[ 'type3' ] ==  '：k3')
      {
        if( !empty( $this->kxTpr_S1[ 'BigStory' ] ))
        {
          $_tag = 988;
        }
        else
        {
          $_tag = $this->kxTpr_S1[ 'kxtt' ][ 'character_number' ];
        }
        $this->kxTpr_S1[ 'raireki' ]	.=   kx_CLASS_kxx(
        [
          'text_c'				=>	"来歴　─　脚本",
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c'. $_tag,
          'search'				=>	ucfirst($this->kxTpr_S1[ 'kxtt' ][ 'work_code' ] ).'≫',
          'title_s'				=>	'来歴＄',
          'new_content'  =>  '＿raretu c＝001,989＿',
          'new_title'			=>	$sakuhin_world.'＞c'. $_tag .'＞'.ucfirst($this->kxTpr_S1[ 'kxtt' ][ 'work_code' ] ).'≫来歴',
        ] );

          $_code  = '';
          $_code .= ucfirst($this->kxTpr_S1[ 'kxtt' ][ 'work_code_top3' ]);
          //$_code .= $sakuhin_world_num;
          $_code .= ucfirst($this->kxTpr_S1[ 'kxtt' ][ 'work_code_number' ]);


        /*
        $this->kxTpr_S1[ 'raireki' ]	.=   kx_CLASS_kxx(
        [
          'text_c'				=>	"来歴　─　脚本",
          't'							=>	65,
          'cat'						=>	$this->kxTpr_S1[ 'cat_end' ],
          'tag'						=>	'c988',
          'search'				=>	$_code.'≫',
          'title_s'				=>	'来歴＄',
          'new_content'  =>  '＿raretu c＝001,989＿',
          'new_title'			=>	$sakuhin_world.'＞c988＞'.$_code.'≫来歴',
        ] );
         */
      }
    }
  }
}

?>

<html>
  <head>
  </head>
<body>

  <?php
    if( !empty( $_arr[ 'update_check' ] ) )
    {
      echo 'update_check-ON';
      echo $_arr[ 'update_check' ];
    }
  ?>

  <?php echo $_arr[ 'style_css' ]; ?>

  <div class="__relation2" style="white-space: nowrap;">

    <div>

      <div style="margin:0 20px 5px 0;display: inline-block;">

        Type：<?php echo $_arr[ 'type2' ] . $_arr[ 'type3' ]; ?>

      </div>

      <div style="margin:0 20px 5px 0;display: inline-block;">

        ━━━

      </div>

      <div style="margin:0 20px 5px 0;display: inline-block;">

        参照：<?php echo $_arr[ 'SyncType' ]; ?>

      </div>

    </div>

    <hr>

    <?php echo $_arr[ 'SyncCategory' ]; ?>

    <?php echo $_arr[ 'str' ]; ?>

    <hr>


    <h6>system</h6>

    <div>
      Title：<?php echo $_arr[ 'title' ]; ?>
    </div>

    <div>
      title1：<?php echo $_arr[ 'title1' ]; ?> - ID：<?php echo $_GET[ 'id' ]; ?>
    </div>

    <div>
      p_top_relation.php
    </div>


  </div>
</body>
</html>