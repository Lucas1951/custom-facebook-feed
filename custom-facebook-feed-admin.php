<? php 
función  cff_menu ()  {
    add_menu_page (
        '' ,
        'Facebook RSS' ,
        'manage_options' ,
        'CFF-top' ,
        'Cff_settings_page'
    );
    add_submenu_page (
        'CFF-top' ,
        'Configuración' ,
        'Configuración' ,
        'manage_options' ,
        'CFF-top' ,
        'Cff_settings_page'
    );
}
add_action ( 'admin_menu' ,  'cff_menu' );
// Añadir página estilo
función  cff_styling_menu ()  {
    add_submenu_page (
        'CFF-top' ,
        'Diseño y Estilo' ,
        'Diseño y Estilo' ,
        'manage_options' ,
        'Estilo cff' ,
        'Cff_style_page'
    );
}
add_action ( 'admin_menu' ,  'cff_styling_menu' );
// Crear la página Configuración
función  cff_settings_page ()  {
    // Declarar variables para campos
    $ Hidden_field_name       =  'cff_submit_hidden' ;
    $ Señal_acceso            =  'cff_access_token' ;
    $ Page_id                 =  'cff_page_id' ;
    $ Num_show                =  'cff_num_show' ;
    $ Cff_post_limit          =  'cff_post_limit' ;
    $ cff_show_others         =  'cff_show_others' ;
    $ Cff_cache_time          =  'cff_cache_time' ;
    $ Cff_cache_time_unit     =  'cff_cache_time_unit' ;
    $ Cff_locale              =  'cff_locale' ;
    // Leer en valor de la opción existente de base de datos
    $ Access_token_val  =  get_option (  $ señal_acceso  );
    $ Page_id_val  =  get_option (  $ page_id  );
    $ Num_show_val  =  get_option (  $ num_show ,  '5'  );
    $ Cff_post_limit_val  =  get_option (  $ cff_post_limit  );
    $ Cff_show_others_val  =  get_option (  $ cff_show_others  );
    $ Cff_cache_time_val  =  get_option (  $ cff_cache_time ,  '1'  );
    $ Cff_cache_time_unit_val  =  get_option (  $ cff_cache_time_unit ,  'hora'  );
    $ Cff_locale_val  =  get_option (  $ cff_locale ,  'en_US'  );
    // A ver si el usuario nos ha publicado alguna información. Si lo hicieran, este campo oculto se establece en 'Y'.
    si (  isset ( $ _POST [  $ hidden_field_name  ])  &&  $ _POST [  $ hidden_field_name  ]  ==  "Y"  )  {
        // Leer el valor publicado
        $ Access_token_val  =  $ _POST [  $ señal_acceso  ];
        $ Page_id_val  =  $ _POST [  $ page_id  ];
        $ Num_show_val  =  $ _POST [  $ num_show  ];
        $ Cff_post_limit_val  =  $ _POST [  $ cff_post_limit  ];
        $ Cff_show_others_val  =  $ _POST [  $ cff_show_others  ];
        $ Cff_cache_time_val  =  $ _POST [  $ cff_cache_time  ];
        $ Cff_cache_time_unit_val  =  $ _POST [  $ cff_cache_time_unit  ];
        $ Cff_locale_val  =  $ _POST [  $ cff_locale  ];
        // Guardar el valor publicado en la base de datos
        update_option (  $ señal_acceso ,  $ access_token_val  );
        update_option (  $ page_id ,  $ page_id_val  );
        update_option (  $ num_show ,  $ num_show_val  );
        update_option (  $ cff_post_limit ,  $ cff_post_limit_val  );
        update_option (  $ cff_show_others ,  $ cff_show_others_val  );
        update_option (  $ cff_cache_time ,  $ cff_cache_time_val  );
        update_option (  $ cff_cache_time_unit ,  $ cff_cache_time_unit_val  );
        update_option (  $ cff_locale ,  $ cff_locale_val  );
        
        // Eliminar el transitorio para la página principal de identificación
        delete_transient (  'cff_posts_json_'  . $ page_id_val  );
        delete_transient (  'cff_feed_json_'  . $ page_id_val  );
        delete_transient (  'cff_events_json_'  .  $ page_id_val  );
        // Eliminar todos los transitorios
        mundial  $ wpdb ;
        $ Nombre_tabla  =  $ wpdb -> prefijo  .  "opciones" ;
        $ Wpdb -> consulta (  "
            BORRAR
            DESDE $ nombre_tabla
            DONDE `option_name` LIKE ('% cff \ _posts \ _json \ _%')
            "  );
        $ Wpdb -> consulta (  "
            BORRAR
            DESDE $ nombre_tabla
            DONDE `option_name` LIKE ('% cff \ _feed \ _json \ _%')
            "  );
        $ Wpdb -> consulta (  "
            BORRAR
            DESDE $ nombre_tabla
            DONDE `option_name` LIKE ('% cff \ _events \ _json \ _%')
            "  );
        // Poner ajustes mensaje actualizado en la pantalla 
    ?>
    <Div class = "actualizado"> <p> <strong> <? php  _e ( 'Ajustes guardados.' ,  'costumbre-facebook-feed'  );  ?> </ strong> </ p> </ div>
    <? Php  }  ?> 
 
    <Div id = clase "CFF-admin" = "wrap">
        <Div id = "header">
            <H1> <? php  _E ( 'personalizada de Facebook para piensos Configuración' );  ?> </ h1>
        </ Div>
        <Form name = "Form1" method = "post" action = "">
            <Input type = "hidden" name = " <? php?  echo  $ hidden_field_name ;  ?> "value =" Y ">
            <br />
            <H3> <? php  _e ( 'Configuración' );  ?> </ h3>
            <Table class = "forma-mesa">
                <Tbody>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'Acceso Token' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_access_token" = "text" value = " <? php?  esc_attr_e (  $ access_token_val  );  ?> "size =" 60 "/>
                            <! - <A href = id "#" = "verify-token" class = "botón secundario"> <? php?  _e ( 'Verificar Acceso Token' );  ?> </a> ->
                            & Nbsp; <a class="tooltip-link" href="JavaScript:void(0);"> <? php?  _e ( '¿Cómo conseguir un token de acceso' );  ?> </a>
                            <br /> <i style = "color: # 666; font-size: 11px;"> Por ejemplo. 1234567890123 | ABC2fvp5h9tJe4-5-ABC123 </ i>
                            <P class = "tooltip"> <? php  _e ( "Para utilizar el plugin, Facebook le requiere para obtener un token de acceso para acceder a sus datos. Pero no te preocupes, esto es muy fácil de hacer. Sólo tienes que seguir el paso a paso las instrucciones en el siguiente enlace: <a href='http://smashballoon.com/custom-facebook-feed/access token/'-target='_blank'> Cómo obtener un token de acceso de Facebook </ a> " );  ?> . </ p>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'página de Facebook ID' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_page_id" = "text" value = " <? php?  esc_attr_e (  $ page_id_val  );  ?> "size =" 60 "/>
                            & Nbsp; <a class="tooltip-link" href="JavaScript:void(0);"> <? php?  _e ( 'What \' s mi Página ID '? );  ?> </a>
                            <br /> <i style = "color: # 666; font-size: 11px;"> Por ejemplo. 1234567890123 o smashballoon </ i>
                            <P class = "tooltip"> <? php?  _e ( 'Si usted tiene una página en Facebook con una URL como esta:' );  ?> <code> https://www.facebook.com/your_page_name </ code> < ? php  _e ( 'entonces el ID de página es sólo' );  ?> . <b> your_page_name </ b> <? php  _e ( 'Si la URL de su página se estructura como esta:' );  >? <code> https: //www.facebook.com/pages/your_page_name/123654123654123 </ code> <? php  _e ( 'entonces el ID de la página es en realidad el número al final, por lo que en este caso' );  ?> <b> 123654123654123 </ b>. </ p>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'Número de mensajes para mostrar' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_num_show" = "text" value = " <? php?  esc_attr_e (  $ num_show_val  );  ?> "size =" 4 "/>
                            <I style = "color: # 666; font-size: 11px;"> Por ejemplo. 5 </ i>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'Alterar el límite posterior' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_post_limit" = "text" value = " <? php?  esc_attr_e (  $ cff_post_limit_val  );  ?> "size =" 4 "/>
                            <I style = "color: # 666; font-size: 11px;"> Por ejemplo. 50 </ i> <a class="tooltip-enlace bache-left" href="JavaScript:void(0);"> <? php?  _e ( '¿Qué significa esto?' );  ?> </a>
                            <P class = "tooltip"> <? php  _e ( 'Por defecto, el API de Facebook sólo devuelve sus últimas 25 entradas. Si desea obtener más de 25 puestos entonces usted puede aumentar el límite de la especificación de un valor más alto que aquí. Sin embargo , los más puestos que solicitan más lento es el tiempo de carga de la página puede ser cuando el plugin necesita para comprobar Facebook para nuevos puestos. Del mismo modo, si usted sólo tiene la intención de recuperar algunos puestos entonces puede que desee establecer un límite inferior de post aquí para que usted aren \ 't recuperar más puestos que sea necesario.' );  ?> </ p>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php  _E ( 'Mostrar los posts de otros en mi página' );  ?> <br /> <i style = "color: # 666; font-size: 11px;"> <? php  _e ( '(Marque esto si el uso de un grupo)' );  ?> </ i> </ th>
                        <Td>
                            <Input name = tipo "cff_show_others" = "checkbox" id = "cff_show_others" <? php  si ( $ cff_show_others_val  ==  cierto )  echo  "verificado" ;  ?> />
                            <I style = "color: # 666; font-size: 11px;"> <? php?  _e ( 'Por defecto sólo se mostrarán los mensajes de la propietario de la página Marque esta casilla para mostrar también los mensajes de los demás..' );  ? > </ yo>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( "Consultar para nuevos mensajes de Facebook cada ' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_cache_time" = "text" value = " <? php?  esc_attr_e (  $ cff_cache_time_val  );  ?> "size =" 4 "/>
                            <Select name = "cff_cache_time_unit">
                                <Opción value="minutes" <?php  if ( $cff_cache_time_unit_val  ==  "minutes" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Minutes' );  ?> </option>
                                <Opción value="hours" <?php  if ( $cff_cache_time_unit_val  ==  "hours" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Hours' );  ?> </option>
                                <Opción value="days" <?php  if ( $cff_cache_time_unit_val  ==  "days" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Days' );  ?> </option>
                            </ Select>
                            <a class="tooltip-enlace bache-left" href="JavaScript:void(0);"> <? php?  _e ( '¿Qué significa esto?' );  ?> </a>
                            <P class = "tooltip"> <? php  _e ( 'Sus mensajes y comentarios de Facebook de datos se almacena en caché temporalmente por el plug-in en su base de datos de WordPress. Usted puede elegir el tiempo que estos datos deben ser almacenados en caché para. Si se establece el tiempo de 60 minutos después el plugin se borrarán los datos almacenados en caché después de ese periodo de tiempo, y la próxima vez que la página se ve que va a comprobar si hay nuevos datos ". );  ?> </ p>
                        </ Td>
                    </ Tr>

                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( "localización" );  ?> </ th>
                        <Td>
                            <Select name = "cff_locale">
                                <Opción value="af_ZA" <?php  if ( $cff_locale_val  ==  "af_ZA" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Afrikaans' );  ?> </option>
                                <Opción value="ar_AR" <?php  if ( $cff_locale_val  ==  "ar_AR" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Arabic' );  ?> </option>
                                <Opción value="az_AZ" <?php  if ( $cff_locale_val  ==  "az_AZ" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Azerbaijani' );  ?> </option>
                                <Opción value="be_BY" <?php  if ( $cff_locale_val  ==  "be_BY" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Belarusian' );  ?> </option>
                                <Opción value="bg_BG" <?php  if ( $cff_locale_val  ==  "bg_BG" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Bulgarian' );  ?> </option>
                                <Opción value="bn_IN" <?php  if ( $cff_locale_val  ==  "bn_IN" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Bengali' );  ?> </option>
                                <Opción value="bs_BA" <?php  if ( $cff_locale_val  ==  "bs_BA" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Bosnian' );  ?> </option>
                                <Opción value="ca_ES" <?php  if ( $cff_locale_val  ==  "ca_ES" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Catalan' );  ?> </option>
                                <Opción value="cs_CZ" <?php  if ( $cff_locale_val  ==  "cs_CZ" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Czech' );  ?> </option>
                                <Opción value="cy_GB" <?php  if ( $cff_locale_val  ==  "cy_GB" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Welsh' );  ?> </option>
                                <Opción value="da_DK" <?php  if ( $cff_locale_val  ==  "da_DK" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Danish' );  ?> </option>
                                <Opción value="de_DE" <?php  if ( $cff_locale_val  ==  "de_DE" )  echo  'selected="selected"'  ?> > <?php  _e ( 'German' );  ?> </option>
                                <Opción value="el_GR" <?php  if ( $cff_locale_val  ==  "el_GR" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Greek' );  ?> </option>
                                <Option value = "es_ES" <? php  si ( $ cff_locale_val  ==  "es_ES" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Inglés (Reino Unido)' );  ?> </ option>
                                <Option value = "en_PI" <? php  si ( $ cff_locale_val  ==  "en_PI" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Inglés (pirata)' );  ?> </ option>
                                <Option value = "en_UD" <? php  si ( $ cff_locale_val  ==  "en_UD" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Inglés (Al revés)' );  ?> </ option >
                                <Option value = "en_US" <? php  si ( $ cff_locale_val  ==  "en_US" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Inglés (US)' );  ?> </ option>
                                <Opción value="eo_EO" <?php  if ( $cff_locale_val  ==  "eo_EO" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Esperanto' );  ?> </option>
                                <option value = "es_ES" <? php?  si ( $ cff_locale_val  ==  "es_ES" )  echo  "selected =" selected "'  >? > <? php?  _e ( 'Español (España)' );  ?> </ option>
                                <Opción value="es_LA" <?php  if ( $cff_locale_val  ==  "es_LA" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Spanish' );  ?> </option>
                                <Opción value="et_EE" <?php  if ( $cff_locale_val  ==  "et_EE" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Estonian' );  ?> </option>
                                <Opción value="eu_ES" <?php  if ( $cff_locale_val  ==  "eu_ES" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Basque' );  ?> </option>
                                <Opción value="fa_IR" <?php  if ( $cff_locale_val  ==  "fa_IR" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Persian' );  ?> </option>
                                <Option value = "fb_LT" <? php  si ( $ cff_locale_val  ==  "fb_LT" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Leet Speak' );  ?> </ option>
                                <Opción value="fi_FI" <?php  if ( $cff_locale_val  ==  "fi_FI" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Finnish' );  ?> </option>
                                <Opción value="fo_FO" <?php  if ( $cff_locale_val  ==  "fo_FO" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Faroese' );  ?> </option>
                                <Option value = "fr_CA" <? php  si ( $ cff_locale_val  ==  "fr_CA" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Francés (Canadá)' );  ?> </ option>
                                <Option value = "fr_FR" <? php  si ( $ cff_locale_val  ==  "fr_FR" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Francés (Francia)' );  ?> </ option>
                                <Opción value="fy_NL" <?php  if ( $cff_locale_val  ==  "fy_NL" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Frisian' );  ?> </option>
                                <Opción value="ga_IE" <?php  if ( $cff_locale_val  ==  "ga_IE" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Irish' );  ?> </option>
                                <Opción value="gl_ES" <?php  if ( $cff_locale_val  ==  "gl_ES" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Galician' );  ?> </option>
                                <Opción value="he_IL" <?php  if ( $cff_locale_val  ==  "he_IL" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Hebrew' );  ?> </option>
                                <Opción value="hi_IN" <?php  if ( $cff_locale_val  ==  "hi_IN" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Hindi' );  ?> </option>
                                <Opción value="hr_HR" <?php  if ( $cff_locale_val  ==  "hr_HR" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Croatian' );  ?> </option>
                                <Opción value="hu_HU" <?php  if ( $cff_locale_val  ==  "hu_HU" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Hungarian' );  ?> </option>
                                <Opción value="hy_AM" <?php  if ( $cff_locale_val  ==  "hy_AM" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Armenian' );  ?> </option>
                                <Opción value="id_ID" <?php  if ( $cff_locale_val  ==  "id_ID" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Indonesian' );  ?> </option>
                                <Opción value="is_IS" <?php  if ( $cff_locale_val  ==  "is_IS" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Icelandic' );  ?> </option>
                                <Opción value="it_IT" <?php  if ( $cff_locale_val  ==  "it_IT" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Italian' );  ?> </option>
                                <Opción value="ja_JP" <?php  if ( $cff_locale_val  ==  "ja_JP" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Japanese' );  ?> </option>
                                <Opción value="ka_GE" <?php  if ( $cff_locale_val  ==  "ka_GE" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Georgian' );  ?> </option>
                                <Opción value="km_KH" <?php  if ( $cff_locale_val  ==  "km_KH" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Khmer' );  ?> </option>
                                <Opción value="ko_KR" <?php  if ( $cff_locale_val  ==  "ko_KR" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Korean' );  ?> </option>
                                <Opción value="ku_TR" <?php  if ( $cff_locale_val  ==  "ku_TR" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Kurdish' );  ?> </option>
                                <Opción value="la_VA" <?php  if ( $cff_locale_val  ==  "la_VA" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Latin' );  ?> </option>
                                <Opción value="lt_LT" <?php  if ( $cff_locale_val  ==  "lt_LT" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Lithuanian' );  ?> </option>
                                <Opción value="lv_LV" <?php  if ( $cff_locale_val  ==  "lv_LV" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Latvian' );  ?> </option>
                                <Opción value="mk_MK" <?php  if ( $cff_locale_val  ==  "mk_MK" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Macedonian' );  ?> </option>
                                <Opción value="ml_IN" <?php  if ( $cff_locale_val  ==  "ml_IN" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Malayalam' );  ?> </option>
                                <Opción value="ms_MY" <?php  if ( $cff_locale_val  ==  "ms_MY" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Malay' );  ?> </option>
                                <Option value = "nb_NO" <? php  si ( $ cff_locale_val  ==  "nb_NO" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Noruego (Bokmal)' );  ?> </ option>
                                <Opción value="ne_NP" <?php  if ( $cff_locale_val  ==  "ne_NP" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Nepali' );  ?> </option>
                                <Opción value="nl_NL" <?php  if ( $cff_locale_val  ==  "nl_NL" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Dutch' );  ?> </option>
                                <Option value = "nn_NO" <? php  si ( $ cff_locale_val  ==  "nn_NO" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Norwegian (Nynorsk)' );  ?> </ option>
                                <Opción value="pa_IN" <?php  if ( $cff_locale_val  ==  "pa_IN" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Punjabi' );  ?> </option>
                                <Opción value="pl_PL" <?php  if ( $cff_locale_val  ==  "pl_PL" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Polish' );  ?> </option>
                                <Opción value="ps_AF" <?php  if ( $cff_locale_val  ==  "ps_AF" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Pashto' );  ?> </option>
                                <Option value = "es_ES" <? php  si ( $ cff_locale_val  ==  "es_ES" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Portugués (Brasil)' );  ?> </ option>
                                <Option value = "pt_PT" <? php  si ( $ cff_locale_val  ==  "pt_PT" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Portugués (Portugal)' );  ?> </ option>
                                <Opción value="ro_RO" <?php  if ( $cff_locale_val  ==  "ro_RO" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Romanian' );  ?> </option>
                                <Opción value="ru_RU" <?php  if ( $cff_locale_val  ==  "ru_RU" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Russian' );  ?> </option>
                                <Opción value="sk_SK" <?php  if ( $cff_locale_val  ==  "sk_SK" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Slovak' );  ?> </option>
                                <Opción value="sl_SI" <?php  if ( $cff_locale_val  ==  "sl_SI" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Slovenian' );  ?> </option>
                                <Opción value="sq_AL" <?php  if ( $cff_locale_val  ==  "sq_AL" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Albanian' );  ?> </option>
                                <Opción value="sr_RS" <?php  if ( $cff_locale_val  ==  "sr_RS" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Serbian' );  ?> </option>
                                <Opción value="sv_SE" <?php  if ( $cff_locale_val  ==  "sv_SE" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Swedish' );  ?> </option>
                                <Opción value="sw_KE" <?php  if ( $cff_locale_val  ==  "sw_KE" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Swahili' );  ?> </option>
                                <Opción value="ta_IN" <?php  if ( $cff_locale_val  ==  "ta_IN" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Tamil' );  ?> </option>
                                <Opción value="te_IN" <?php  if ( $cff_locale_val  ==  "te_IN" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Telugu' );  ?> </option>
                                <Opción value="th_TH" <?php  if ( $cff_locale_val  ==  "th_TH" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Thai' );  ?> </option>
                                <Opción value="tl_PH" <?php  if ( $cff_locale_val  ==  "tl_PH" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Filipino' );  ?> </option>
                                <Opción value="tr_TR" <?php  if ( $cff_locale_val  ==  "tr_TR" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Turkish' );  ?> </option>
                                <Opción value="uk_UA" <?php  if ( $cff_locale_val  ==  "uk_UA" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Ukrainian' );  ?> </option>
                                <Opción value="vi_VN" <?php  if ( $cff_locale_val  ==  "vi_VN" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Vietnamese' );  ?> </option>
                                <Option value = "zh_CN" <? php  si ( $ cff_locale_val  ==  "zh_CN" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'chino simplificado (China)' );  ?> </ option >
                                <Option value = "zh_HK" <? php  si ( $ cff_locale_val  ==  "zh_HK" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'Tradicional China (Hong Kong)' );  ?> </ opción>
                                <Option value = "zh_TW" <? php  si ( $ cff_locale_val  ==  "zh_TW" )  echo  "selected =" selecciona "'  >? > <? php?  _e ( 'chino tradicional (Taiwán)' );  ?> </ option >
                            </ Select>
                            <I style = "color: # 666; font-size: 11px;"> <? php  _e ( 'Seleccione un idioma' );  ?> </ i>
                        </ Td>
                    </ Tr>
                    
                </ Tbody>
            </ Table>
            <? Php  submit_button ();  ?>
        </ Form>
        <H3> <? php  _e ( 'Support' );  ?> </ h3>
        <P> Tener problemas para conseguir que el plugin funciona? Trate de visitar el <a target="_blank" href="http://smashballoon.com/custom-facebook-feed/troubleshooting/" /> Solución de problemas </a> página, <a href = "http: // smashballoon. com / custom-facebook-alimentación / faq / "target =" _ blank "página /> ​​FAQ </a>, o contacto <a href =" http://smashballoon.com/custom-facebook-feed/support objetivo "= "_blank"> apoyo </a>. <br /> rotura violenta del globo se ha comprometido a hacer mejor este plugin. Por favor, háganos saber si usted ha tenido algún problema al utilizar este plugin para que podamos seguir mejorando él! </ P>
        <Hr />
        <H3> <? php  _e ( 'Viendo su alimentación' );  ?> </ h3>
        <P> <? php?  _e ( 'Copia y pega este código corto directamente en la página, publicar o widget de donde usted \' d como la alimentación a aparecer: ' );  ?> </ p>
        <Input type = "text" value = "[custom-facebook-alimentación]" size = "22" readonly = "readonly" onclick = "this.focus (); this.select ()" id = "sistema-INFO- área de texto "name =" "title =" edd-sysinfo <? php?  _e ( 'Para copiar, haga clic en el campo a continuación, pulse Ctrl + C (PC) o Cmd + C (Mac).' );  ?> "/>
        <P> <? php  _e ( 'Si lo desea, puede anular los ajustes anteriores directamente en el código corto de este modo:' );  ?> </ p>
        <P> [-custom facebook-alimentación <b> <span style = "color: purple;"> id = Put_Your_Facebook_Page_ID_Here </ span> <span style = "color: green;"> num = 3 </ span> <span style = 'color: blue; "> diseño = pulgar </ span> </ b>] </ p>
        <P> <a href="http://smashballoon.com/custom-facebook-feed/docs/shortcodes/" target="_blank"> <? php  _e ( 'Pulse aquí' );  ?> </a> <? php  _e ( 'para obtener una lista completa de opciones shortcode' );  ?> </ p>
        <Hr />
        
        <a href="http://smashballoon.com/custom-facebook-feed/demo" target="_blank"> <img src = " <? php  echo  plugins_url () . '/ wp-facebook-alimentación / img / pro.png ' ;  ?> "/> </a>
        <Hr />
        <H4> <? php  _e ( '<u> Información del Sistema: </ u>' );  ?> </ h4>
        <P> Versión PHP: <b> <? php  echo  PHP_VERSION  .  " \ n " ;  ?> </ b> </ p>
        <P> Información del servidor Web: <b> <? php  echo  $ _SERVER [ 'SERVER_SOFTWARE' ]  .  " \ n " ;  ?> </ b> </ p>
        <P> PHP allow_url_fopen: <b> <? php?  eco  ini_get (  'allow_url_fopen'  )  ?  "<span style =" color: green; "> Sí </ span>"  :  "<span style =" color: red; " > No </ span> " ;  ?> </ b> </ p>
        <P> PHP CURL: <b> <? php?  eco  is_callable ( 'curl_init' )  ?  "<span style =" color: green; "> Sí </ span>"  :  "<span style =" color: red; " > No </ span> "  ?> </ b> </ p>
        <P> JSON: <b> <? php  echo  function_exists ( "json_decode" )  ?  "<span style =" Color: verde; "> Sí </ span>"  :  "<span style =" color: red; "> No </ span> "  ?> </ b> </ p>
        <I style = "color: # 666; font-size: 11px;"> <? php?  _e ( '(Si alguno de los elementos anteriores se muestran como' );  ?> <span style = "color: red;"> No </ span> <? php  _e ( 'a continuación, por favor incluya esto en su solicitud de soporte)' );  ?> </ i>
        
        
<? Php 
}  // Fin Settings_Page
// Crear la página Estilo
función  cff_style_page ()  {
    // Declarar variables para campos
    $ Style_hidden_field_name                 =  'cff_style_submit_hidden' ;
    $ Style_general_hidden_field_name         =  'cff_style_general_submit_hidden' ;
    $ Style_post_layout_hidden_field_name     =  'cff_style_post_layout_submit_hidden' ;
    $ Style_typography_hidden_field_name      =  'cff_style_typography_submit_hidden' ;
    $ Style_misc_hidden_field_name            =  'cff_style_misc_submit_hidden' ;
    $ defecto  =  array (
        // Pon tipos
        'Cff_show_links_type'        =>  cierto ,
        'Cff_show_event_type'        =>  cierto ,
        'Cff_show_video_type'        =>  cierto ,
        'Cff_show_photos_type'       =>  cierto ,
        'Cff_show_status_type'       =>  cierto ,
        // Diseño
        'Cff_preset_layout'          =>  'pulgar' ,
        // Incluir
        'Cff_show_text'              =>  cierto ,
        'Cff_show_desc'              =>  cierto ,
        'Cff_show_shared_links'      =>  cierto ,
        'Cff_show_date'              =>  cierto ,
        'Cff_show_media'             =>  cierto ,
        'Cff_show_event_title'       =>  cierto ,
        'Cff_show_event_details'     =>  cierto ,
        'Cff_show_meta'              =>  cierto ,
        'Cff_show_link'              =>  cierto ,
        'Cff_show_like_box'          =>  cierto ,
        // Tipografía
        'Cff_see_more_text'          =>  'Ver Más' ,
        'Cff_see_less_text'          =>  'Ver menos' ,
        'Cff_title_format'           =>  'p' ,
        'Cff_title_size'             =>  'hereda' ,
        'Cff_title_weight'           =>  'hereda' ,
        'Cff_title_color'            =>  '' ,
        'Cff_body_size'              =>  'hereda' ,
        'Cff_body_weight'            =>  'hereda' ,
        'Cff_body_color'             =>  '' ,
        // Título del evento
        'Cff_event_title_format'     =>  'p' ,
        'Cff_event_title_size'       =>  'hereda' ,
        'Cff_event_title_weight'     =>  'hereda' ,
        'Cff_event_title_color'      =>  '' ,
        // Fecha del evento
        'Cff_event_date_size'        =>  'hereda' ,
        'Cff_event_date_weight'      =>  'hereda' ,
        'Cff_event_date_color'       =>  '' ,
        'Cff_event_date_position'    =>  'abajo' ,
        'Cff_event_date_formatting'  =>  '1' ,
        'Cff_event_date_custom'      =>  '' ,
        // Detalles del evento
        'Cff_event_details_size'     =>  'hereda' ,
        'Cff_event_details_weight'   =>  'hereda' ,
        'Cff_event_details_color'    =>  '' ,
        // Fecha
        'Cff_date_position'          =>  'abajo' ,
        'Cff_date_size'              =>  'hereda' ,
        'Cff_date_weight'            =>  'hereda' ,
        'Cff_date_color'             =>  '' ,
        'Cff_date_formatting'        =>  '1' ,
        'Cff_date_custom'            =>  '' ,
        'Cff_date_before'            =>  '' ,
        'Cff_date_after'             =>  '' ,
        // Enlace a Facebook
        'Cff_link_size'              =>  'hereda' ,
        'Cff_link_weight'            =>  'hereda' ,
        'Cff_link_color'             =>  '' ,
        'Cff_facebook_link_text'     =>  'Ver en Facebook' ,
        'Cff_view_link_text'         =>  'Ver Link' ,
        'Cff_link_to_timeline'           =>  false ,
        // Meta
        'Cff_icon_style'             =>  'luz' ,
        'Cff_meta_text_color'        =>  '' ,
        'Cff_meta_bg_color'          =>  '' ,
        'Cff_nocomments_text'        =>  'No hay comentarios todavía' ,
        'Cff_hide_comments'          =>  '' ,
        // Varios
        'Cff_feed_width'             =>  '' ,
        'Cff_feed_height'            =>  '' ,
        'Cff_feed_padding'           =>  '' ,
        'Cff_like_box_position'      =>  'inferior' ,
        'Cff_like_box_outside'       =>  false ,
        'Cff_likebox_width'          =>  '300' ,
        'Cff_like_box_faces'         =>  false ,

        'Cff_bg_color'               =>  '' ,
        'Cff_likebox_bg_color'       =>  '' ,
        'Cff_video_height'           =>  '' ,
        'Cff_show_author'            =>  false ,
        'Cff_class'                  =>  '' ,
        // Nueva
        'Cff_custom_css'             =>  '' ,
        'Cff_title_link'             =>  false ,
        'Cff_event_title_link'       =>  false ,
        'Cff_video_action'           =>  'archivo' ,
        'Cff_sep_color'              =>  '' ,
        'Cff_sep_size'               =>  '1'
    );
    // Opción de diseño Guardar en un array
    add_option (  'cff_style_settings' ,  $ opciones  );
    $ opciones  =  wp_parse_args ( get_option ( 'cff_style_settings' ),  $ por defecto );
    // Establecer las variables de página
    // Pon tipos
    $ Cff_show_links_type  =  $ options [  'cff_show_links_type'  ];
    $ Cff_show_event_type  =  $ options [  'cff_show_event_type'  ];
    $ Cff_show_video_type  =  $ options [  'cff_show_video_type'  ];
    $ Cff_show_photos_type  =  $ options [  'cff_show_photos_type'  ];
    $ Cff_show_status_type  =  $ options [  'cff_show_status_type'  ];
    // Diseño
    $ Cff_preset_layout  =  $ options [  'cff_preset_layout'  ];
    // Incluir
    $ Cff_show_text  =  $ options [  'cff_show_text'  ];
    $ Cff_show_desc  =  $ options [  'cff_show_desc'  ];
    $ Cff_show_shared_links  =  $ opciones [  'cff_show_shared_links'  ];
    $ Cff_show_date  =  $ options [  'cff_show_date'  ];
    $ Cff_show_media  =  $ options [  'cff_show_media'  ];
    $ Cff_show_event_title  =  $ options [  'cff_show_event_title'  ];
    $ Cff_show_event_details  =  $ opciones [  'cff_show_event_details'  ];
    $ Cff_show_meta  =  $ options [  'cff_show_meta'  ];
    $ Cff_show_link  =  $ options [  'cff_show_link'  ];
    $ Cff_show_like_box  =  $ options [  'cff_show_like_box'  ];
    // Tipografía
    $ Cff_see_more_text  =  $ options [  'cff_see_more_text'  ];
    $ Cff_see_less_text  =  $ options [  'cff_see_less_text'  ];
    $ Cff_title_format  =  $ options [  'cff_title_format'  ];
    $ Cff_title_size  =  $ options [  'cff_title_size'  ];
    $ Cff_title_weight  =  $ options [  'cff_title_weight'  ];
    $ Cff_title_color  =  $ options [  'cff_title_color'  ];
    $ Cff_body_size  =  $ options [  'cff_body_size'  ];
    $ Cff_body_weight  =  $ options [  'cff_body_weight'  ];
    $ Cff_body_color  =  $ options [  'cff_body_color'  ];
    // Título del evento
    $ Cff_event_title_format  =  $ options [  'cff_event_title_format'  ];
    $ Cff_event_title_size  =  $ options [  'cff_event_title_size'  ];
    $ Cff_event_title_weight  =  $ options [  'cff_event_title_weight'  ];
    $ Cff_event_title_color  =  $ options [  'cff_event_title_color'  ];
    // Fecha del evento
    $ Cff_event_date_size  =  $ options [  'cff_event_date_size'  ];
    $ Cff_event_date_weight  =  $ options [  'cff_event_date_weight'  ];
    $ Cff_event_date_color  =  $ options [  'cff_event_date_color'  ];
    $ Cff_event_date_position  =  $ options [  'cff_event_date_position'  ];
    $ Cff_event_date_formatting  =  $ options [  'cff_event_date_formatting'  ];
    $ Cff_event_date_custom  =  $ options [  'cff_event_date_custom'  ];
    // Detalles del evento
    $ Cff_event_details_size  =  $ options [  'cff_event_details_size'  ];
    $ Cff_event_details_weight  =  $ options [  'cff_event_details_weight'  ];
    $ Cff_event_details_color  =  $ options [  'cff_event_details_color'  ];
    // Fecha
    $ Cff_date_position  =  $ options [  'cff_date_position'  ];
    $ Cff_date_size  =  $ options [  'cff_date_size'  ];
    $ Cff_date_weight  =  $ options [  'cff_date_weight'  ];
    $ Cff_date_color  =  $ options [  'cff_date_color'  ];
    $ Cff_date_formatting  =  $ options [  'cff_date_formatting'  ];
    $ Cff_date_custom  =  $ options [  'cff_date_custom'  ];
    $ Cff_date_before  =  $ options [  'cff_date_before'  ];
    $ Cff_date_after  =  $ options [  'cff_date_after'  ];
    // Ver en el enlace de Facebook
    $ Cff_link_size  =  $ options [  'cff_link_size'  ];
    $ Cff_link_weight  =  $ options [  'cff_link_weight'  ];
    $ Cff_link_color  =  $ options [  'cff_link_color'  ];
    $ Cff_facebook_link_text  =  $ options [  'cff_facebook_link_text'  ];
    $ Cff_view_link_text  =  $ options [  'cff_view_link_text'  ];
    $ Cff_link_to_timeline  =  $ options [  'cff_link_to_timeline'  ];
    // Meta
    $ Cff_icon_style  =  $ options [  'cff_icon_style'  ];
    $ Cff_meta_text_color  =  $ options [  'cff_meta_text_color'  ];
    $ Cff_meta_bg_color  =  $ options [  'cff_meta_bg_color'  ];
    $ Cff_nocomments_text  =  $ options [  'cff_nocomments_text'  ];
    $ Cff_hide_comments  =  $ opciones [  'cff_hide_comments'  ];
    // Varios
    $ Cff_feed_width  =  $ options [  'cff_feed_width'  ];
    $ Cff_feed_height  =  $ options [  'cff_feed_height'  ];
    $ Cff_feed_padding  =  $ options [  'cff_feed_padding'  ];
    $ Cff_like_box_position  =  $ options [  'cff_like_box_position'  ];
    $ Cff_like_box_outside  =  $ options [  'cff_like_box_outside'  ];
    $ Cff_likebox_width  =  $ options [  'cff_likebox_width'  ];
    $ Cff_like_box_faces  =  $ opciones [  'cff_like_box_faces'  ];

    $ Cff_show_media  =  $ options [  'cff_show_media'  ];
    $ Cff_open_links  =  $ opciones [  'cff_open_links'  ];
    $ Cff_bg_color  =  $ options [  'cff_bg_color'  ];
    $ Cff_likebox_bg_color  =  $ options [  'cff_likebox_bg_color'  ];
    $ Cff_video_height  =  $ options [  'cff_video_height'  ];
    $ Cff_show_author  =  $ options [  'cff_show_author'  ];
    $ Cff_class  =  $ options [  'cff_class'  ];

    // Nueva
    $ Cff_custom_css  =  $ options [  'cff_custom_css'  ];
    $ Cff_title_link  =  $ options [  'cff_title_link'  ];
    $ Cff_event_title_link  =  $ options [  'cff_event_title_link'  ];
    $ Cff_video_action  =  $ options [  'cff_video_action'  ];
    $ Cff_sep_color  =  $ options [  'cff_sep_color'  ];
    $ Cff_sep_size  =  $ options [  'cff_sep_size'  ];
	
	// longitudes Textos
	$ Cff_title_length    =  'cff_title_length' ;
    $ Cff_body_length     =  'cff_body_length' ;
    // Leer en valor de la opción existente de base de datos
    $ Cff_title_length_val  =  get_option (  $ cff_title_length  );
    $ Cff_body_length_val  =  get_option (  $ cff_body_length  );
    // A ver si el usuario nos ha publicado alguna información. Si lo hicieran, este campo oculto se establece en 'Y'.
    si (  isset ( $ _POST [  $ style_hidden_field_name  ])  &&  $ _POST [  $ style_hidden_field_name  ]  ==  "Y"  )  {
        // Actualizar las opciones generales
        si (  isset ( $ _POST [  $ style_general_hidden_field_name  ])  &&  $ _POST [  $ style_general_hidden_field_name  ]  ==  "Y"  )  {
            // General
            $ Cff_feed_width  =  $ _POST [  'cff_feed_width'  ];
            $ Cff_feed_height  =  $ _POST [  'cff_feed_height'  ];
            $ Cff_feed_padding  =  $ _POST [  'cff_feed_padding'  ];
            $ Cff_bg_color  =  $ _POST [  'cff_bg_color'  ];
            $ Cff_show_author  =  $ _POST [  'cff_show_author'  ];
            $ Cff_class  =  $ _POST [  'cff_class'  ];
            // Pon tipos
            $ Cff_show_links_type  =  $ _POST [  'cff_show_links_type'  ];
            $ Cff_show_event_type  =  $ _POST [  'cff_show_event_type'  ];
            $ Cff_show_video_type  =  $ _POST [  'cff_show_video_type'  ];
            $ Cff_show_photos_type  =  $ _POST [  'cff_show_photos_type'  ];
            $ Cff_show_status_type  =  $ _POST [  'cff_show_status_type'  ];
            // General
            $ options [  'cff_feed_width'  ]  =  $ cff_feed_width ;
            $ options [  'cff_feed_height'  ]  =  $ cff_feed_height ;
            $ options [  'cff_feed_padding'  ]  =  $ cff_feed_padding ;
            $ options [  'cff_bg_color'  ]  =  $ cff_bg_color ;
            $ options [  'cff_show_author'  ]  =  $ cff_show_author ;
            $ options [  'cff_class'  ]  =  $ cff_class ;
             // Pon tipos
            $ options [  'cff_show_links_type'  ]  =  $ cff_show_links_type ;
            $ options [  'cff_show_event_type'  ]  =  $ cff_show_event_type ;
            $ options [  'cff_show_video_type'  ]  =  $ cff_show_video_type ;
            $ options [  'cff_show_photos_type'  ]  =  $ cff_show_photos_type ;
            $ options [  'cff_show_status_type'  ]  =  $ cff_show_status_type ;
        }
        // Actualizar las opciones Publicar diseño
        if (  isset ( $_POST [  $style_post_layout_hidden_field_name  ])  &&  $_POST [  $style_post_layout_hidden_field_name  ]  ==  'Y'  )  {
            // Diseño
            $ Cff_preset_layout  =  $ _POST [  'cff_preset_layout'  ];
            // Incluir
            $ Cff_show_text  =  $ _POST [  'cff_show_text'  ];
            $ Cff_show_desc  =  $ _POST [  'cff_show_desc'  ];
            $ Cff_show_shared_links  =  $ _POST [  'cff_show_shared_links'  ];
            $ Cff_show_date  =  $ _POST [  'cff_show_date'  ];
            $ Cff_show_media  =  $ _POST [  'cff_show_media'  ];
            $ Cff_show_event_title  =  $ _POST [  'cff_show_event_title'  ];
            $ Cff_show_event_details  =  $ _POST [  'cff_show_event_details'  ];
            $ Cff_show_meta  =  $ _POST [  'cff_show_meta'  ];
            $ Cff_show_link  =  $ _POST [  'cff_show_link'  ];
            // Diseño
            $ options [  'cff_preset_layout'  ]  =  $ cff_preset_layout ;
            // Incluir
            $ options [  'cff_show_text'  ]  =  $ cff_show_text ;
            $ options [  'cff_show_desc'  ]  =  $ cff_show_desc ;
            $ options [  'cff_show_shared_links'  ]  =  $ cff_show_shared_links ;
            $ options [  'cff_show_date'  ]  =  $ cff_show_date ;
            $ options [  'cff_show_media'  ]  =  $ cff_show_media ;
            $ options [  'cff_show_event_title'  ]  =  $ cff_show_event_title ;
            $ options [  'cff_show_event_details'  ]  =  $ cff_show_event_details ;
            $ options [  'cff_show_meta'  ]  =  $ cff_show_meta ;
            $ options [  'cff_show_link'  ]  =  $ cff_show_link ;
        }
        // Actualizar las opciones Publicar diseño
        if (  isset ( $_POST [  $style_typography_hidden_field_name  ])  &&  $_POST [  $style_typography_hidden_field_name  ]  ==  'Y'  )  {
            // Límite de caracteres
            $ Cff_title_length_val  =  $ _POST [  $ cff_title_length  ];
            $ Cff_body_length_val  =  $ _POST [  $ cff_body_length  ];
            $ Cff_see_more_text  =  $ _POST [  'cff_see_more_text'  ];
            $ Cff_see_less_text  =  $ _POST [  'cff_see_less_text'  ];
            // Tipografía
            $ Cff_title_format  =  $ _POST [  'cff_title_format'  ];
            $ Cff_title_size  =  $ _POST [  'cff_title_size'  ];
            $ Cff_title_weight  =  $ _POST [  'cff_title_weight'  ];
            $ Cff_title_color  =  $ _POST [  'cff_title_color'  ];
            $ Cff_title_link  =  $ _POST [  'cff_title_link'  ];
            $ Cff_body_size  =  $ _POST [  'cff_body_size'  ];
            $ Cff_body_weight  =  $ _POST [  'cff_body_weight'  ];
            $ Cff_body_color  =  $ _POST [  'cff_body_color'  ];
            // Título del evento
            $ Cff_event_title_format  =  $ _POST [  'cff_event_title_format'  ];
            $ Cff_event_title_size  =  $ _POST [  'cff_event_title_size'  ];
            $ Cff_event_title_weight  =  $ _POST [  'cff_event_title_weight'  ];
            $ Cff_event_title_color  =  $ _POST [  'cff_event_title_color'  ];
            $ Cff_event_title_link  =  $ _POST [  'cff_event_title_link'  ];
            // Fecha del evento
            $ Cff_event_date_size  =  $ _POST [  'cff_event_date_size'  ];
            $ Cff_event_date_weight  =  $ _POST [  'cff_event_date_weight'  ];
            $ Cff_event_date_color  =  $ _POST [  'cff_event_date_color'  ];
            $ Cff_event_date_position  =  $ _POST [  'cff_event_date_position'  ];
            $ Cff_event_date_formatting  =  $ _POST [  'cff_event_date_formatting'  ];
            $ Cff_event_date_custom  =  $ _POST [  'cff_event_date_custom'  ];
            // Detalles del evento
            $ Cff_event_details_size  =  $ _POST [  'cff_event_details_size'  ];
            $ Cff_event_details_weight  =  $ _POST [  'cff_event_details_weight'  ];
            $ Cff_event_details_color  =  $ _POST [  'cff_event_details_color'  ];
            // Fecha
            $ Cff_date_position  =  $ _POST [  'cff_date_position'  ];
            $ Cff_date_size  =  $ _POST [  'cff_date_size'  ];
            $ Cff_date_weight  =  $ _POST [  'cff_date_weight'  ];
            $ Cff_date_color  =  $ _POST [  'cff_date_color'  ];
            $ Cff_date_formatting  =  $ _POST [  'cff_date_formatting'  ];
            $ Cff_date_custom  =  $ _POST [  'cff_date_custom'  ];
            $ Cff_date_before  =  $ _POST [  'cff_date_before'  ];
            $ Cff_date_after  =  $ _POST [  'cff_date_after'  ];
            // Ver en el enlace de Facebook
            $ Cff_link_size  =  $ _POST [  'cff_link_size'  ];
            $ Cff_link_weight  =  $ _POST [  'cff_link_weight'  ];
            $ Cff_link_color  =  $ _POST [  'cff_link_color'  ];
            $ Cff_facebook_link_text  =  $ _POST [  'cff_facebook_link_text'  ];
            $ Cff_view_link_text  =  $ _POST [  'cff_view_link_text'  ];
            $ Cff_link_to_timeline  =  $ _POST [  'cff_link_to_timeline'  ];
            // Límite de caracteres
            update_option (  $ cff_title_length ,  $ cff_title_length_val  );
            update_option (  $ cff_body_length ,  $ cff_body_length_val  );
            $ options [  'cff_see_more_text'  ]  =  $ cff_see_more_text ;
            $ options [  'cff_see_less_text'  ]  =  $ cff_see_less_text ;
            // Tipografía
            $ options [  'cff_title_format'  ]  =  $ cff_title_format ;
            $ options [  'cff_title_size'  ]  =  $ cff_title_size ;
            $ options [  'cff_title_weight'  ]  =  $ cff_title_weight ;
            $ options [  'cff_title_color'  ]  =  $ cff_title_color ;
            $ options [  'cff_title_link'  ]  =  $ cff_title_link ;
            $ options [  'cff_body_size'  ]  =  $ cff_body_size ;
            $ options [  'cff_body_weight'  ]  =  $ cff_body_weight ;
            $ options [  'cff_body_color'  ]  =  $ cff_body_color ;
            // Título del evento
            $ options [  'cff_event_title_format'  ]  =  $ cff_event_title_format ;
            $ options [  'cff_event_title_size'  ]  =  $ cff_event_title_size ;
            $ options [  'cff_event_title_weight'  ]  =  $ cff_event_title_weight ;
            $ options [  'cff_event_title_color'  ]  =  $ cff_event_title_color ;
            $ options [  'cff_event_title_link'  ]  =  $ cff_event_title_link ;
            // Fecha del evento
            $ options [  'cff_event_date_size'  ]  =  $ cff_event_date_size ;
            $ options [  'cff_event_date_weight'  ]  =  $ cff_event_date_weight ;
            $ options [  'cff_event_date_color'  ]  =  $ cff_event_date_color ;
            $ options [  'cff_event_date_position'  ]  =  $ cff_event_date_position ;
            $ options [  'cff_event_date_formatting'  ]  =  $ cff_event_date_formatting ;
            $ options [  'cff_event_date_custom'  ]  =  $ cff_event_date_custom ;
            // Detalles del evento
            $ options [  'cff_event_details_size'  ]  =  $ cff_event_details_size ;
            $ options [  'cff_event_details_weight'  ]  =  $ cff_event_details_weight ;
            $ options [  'cff_event_details_color'  ]  =  $ cff_event_details_color ;
            // Fecha
            $ options [  'cff_date_position'  ]  =  $ cff_date_position ;
            $ options [  'cff_date_size'  ]  =  $ cff_date_size ;
            $ options [  'cff_date_weight'  ]  =  $ cff_date_weight ;
            $ options [  'cff_date_color'  ]  =  $ cff_date_color ;
            $ options [  'cff_date_formatting'  ]  =  $ cff_date_formatting ;
            $ options [  'cff_date_custom'  ]  =  $ cff_date_custom ;
            $ options [  'cff_date_before'  ]  =  $ cff_date_before ;
            $ options [  'cff_date_after'  ]  =  $ cff_date_after ;
            // Ver en el enlace de Facebook
            $ options [  'cff_link_size'  ]  =  $ cff_link_size ;
            $ options [  'cff_link_weight'  ]  =  $ cff_link_weight ;
            $ options [  'cff_link_color'  ]  =  $ cff_link_color ;
            $ options [  'cff_facebook_link_text'  ]  =  $ cff_facebook_link_text ;
            $ options [  'cff_view_link_text'  ]  =  $ cff_view_link_text ;
            $ options [  'cff_link_to_timeline'  ]  =  $ cff_link_to_timeline ;
        }
        // Actualizar las opciones Publicar diseño
        si (  isset ( $ _POST [  $ style_misc_hidden_field_name  ])  &&  $ _POST [  $ style_misc_hidden_field_name  ]  ==  "Y"  )  {
            // Meta
            $ Cff_icon_style  =  $ _POST [  'cff_icon_style'  ];
            $ Cff_meta_text_color  =  $ _POST [  'cff_meta_text_color'  ];
            $ Cff_meta_bg_color  =  $ _POST [  'cff_meta_bg_color'  ];
            $ Cff_nocomments_text  =  $ _POST [  'cff_nocomments_text'  ];
            $ Cff_hide_comments  =  $ _POST [  'cff_hide_comments'  ];
            // CSS personalizado
            $ Cff_custom_css  =  $ _POST [  'cff_custom_css'  ];
            // Varios
            $ Cff_show_like_box  =  $ _POST [  'cff_show_like_box'  ];
            $ Cff_like_box_position  =  $ _POST [  'cff_like_box_position'  ];
            $ Cff_like_box_outside  =  $ _POST [  'cff_like_box_outside'  ];
            $ Cff_likebox_bg_color  =  $ _POST [  'cff_likebox_bg_color'  ];
            $ Cff_likebox_width  =  $ _POST [  'cff_likebox_width'  ];
            $ Cff_like_box_faces  =  $ _POST [  'cff_like_box_faces'  ];
            $ Cff_video_height  =  $ _POST [  'cff_video_height'  ];
            $ Cff_video_action  =  $ _POST [  'cff_video_action'  ];
            $ Cff_sep_color  =  $ _POST [  'cff_sep_color'  ];
            $ Cff_sep_size  =  $ _POST [  'cff_sep_size'  ];
            $ Cff_open_links  =  $ _POST [  'cff_open_links'  ];
            // Meta
            $ options [  'cff_icon_style'  ]  =  $ cff_icon_style ;
            $ options [  'cff_meta_text_color'  ]  =  $ cff_meta_text_color ;
            $ options [  'cff_meta_bg_color'  ]  =  $ cff_meta_bg_color ;
            $ options [  'cff_nocomments_text'  ]  =  $ cff_nocomments_text ;
            $ options [  'cff_hide_comments'  ]  =  $ cff_hide_comments ;
            // CSS personalizado
            $ options [  'cff_custom_css'  ]  =  $ cff_custom_css ;
            // Varios
            $ options [  'cff_show_like_box'  ]  =  $ cff_show_like_box ;
            $ options [  'cff_like_box_position'  ]  =  $ cff_like_box_position ;
            $ options [  'cff_like_box_outside'  ]  =  $ cff_like_box_outside ;
            $ options [  'cff_likebox_bg_color'  ]  =  $ cff_likebox_bg_color ;
            $ options [  'cff_likebox_width'  ]  =  $ cff_likebox_width ;
            $ options [  'cff_like_box_faces'  ]  =  $ cff_like_box_faces ;
            
            $ options [  'cff_video_height'  ]  =  $ cff_video_height ;
            $ options [  'cff_video_action'  ]  =  $ cff_video_action ;
            $ options [  'cff_sep_color'  ]  =  $ cff_sep_color ;
            $ options [  'cff_sep_size'  ]  =  $ cff_sep_size ;
            $ options [  'cff_open_links'  ]  =  $ cff_open_links ;
        }
        // Actualizar la matriz
        update_option (  'cff_style_settings' ,  $ opciones  );
        // Poner ajustes mensaje actualizado en la pantalla 
    ?>
    <Div class = "actualizado"> <p> <strong> <? php  _e ( 'Ajustes guardados.' ,  'costumbre-facebook-feed'  );  ?> </ strong> </ p> </ div>
    <? Php  }  ?> 
 
    <Div id = clase "CFF-admin" = "wrap">
        <Div id = "header">
            <H1> <? php  _e ( 'Diseño y Estilo' );  ?> </ h1>
        </ Div>
        <Form name = "Form1" method = "post" action = "">
            <Input type = "hidden" name = " <? php?  echo  $ style_hidden_field_name ;  ?> "value =" Y ">
            <? Php
            $ Active_tab  =  isset (  $ _GET [  'ficha'  ]  )  ?  $ _GET [  'ficha'  ]  :  "general" ;
            ?>
            <H2 class = "nav-tab-wrapper">
                <A href = class = "lengüeta de navegación" page = estilo CFF y tab = general? " <? php?  echo  $ active_tab  ==  'general'  ?  'nav-ficha-activo'  :  '' ;  ?> "> <? php  _e ( "General" );  ?> </a>
                <A href = class = "lengüeta de navegación" page = estilo CFF y tab = post_layout? " <? php?  echo  $ active_tab  ==  'post_layout'  ?  'nav-ficha-activo'  :  '' ;  ?> "> <? php  _e ( 'Publicar Layout' );  ?> </a>
                <A href = "? Page = estilo CFF y tab = tipografía" class="nav-tab <?php  echo  $active_tab  ==  'typography'  ?  'nav-tab-active'  :  '' ;  ?> "> <?php  _e ( 'Typography' );  ?> </a>
                <A href = "page = estilo CFF y tab = misceláneos?" Class = "-pestaña de navegación <? php?  echo  $ active_tab  ==  'misc'  ?  'activo-pestaña de navegación'  :  '' ;  ?> "> <? php  _e ( 'Miscelánea' );  ?> </a>
            </ H2>
            <? Php  si (  $ active_tab  ==  'general'  )  {  // Inicia ficha General?>
            < input  tipo = "oculto"  nombre = "<? php echo? $ style_general_hidden_field_name ;?> "  valor = "Y" >
            < br  />
            < tabla  clase = "forma-mesa" >
                < tbody >
                    < h3 > <? php  _e ( "General" );  ?> </ h3>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'Alimente Ancho' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_feed_width" = "text" value = " <? php?  esc_attr_e (  $ cff_feed_width  );  ?> "size =" 6 "/>
                            <Span> Ej. 500px, 50%, 10em. <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'El valor predeterminado es 100%' );  ?> </ i> </ span>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php  _e ( 'altura de alimentación' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_feed_height" = "text" value = " <? php?  esc_attr_e (  $ cff_feed_height  );  ?> "size =" 6 "/>
                            <Span> Ej. 500px, 50em. <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Dejar en blanco para establecer sin altura máxima Si la alimentación es superior a esta altura y luego una barra de desplazamiento será. usado '. ;)  ?> </ i> </ span>
                        </ Td>
                    </ Tr>
                        <Th scope = "row"> <? php?  _e ( 'Relleno de alimentación' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_feed_padding" = "text" value = " <? php?  esc_attr_e (  $ cff_feed_padding  );  ?> "size =" 6 "/>
                            <Span> Ej. 20 píxeles, 5%. <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( . 'Esta es la cantidad de relleno / espacio que va alrededor de la alimentación Esto es particularmente útil si usted la intención de establecer un color de fondo en la alimentación ". );  ?> </ i> </ span>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'feed Color de fondo' );  ?> </ th>
                        <Td>
                            <Label for = "cff_bg_color"> # </ label>
                            <Input name = tipo "cff_bg_color" = "text" value = " <? php?  esc_attr_e (  $ cff_bg_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                            <Span> <a href="http://www.colorpicker.com/" target="_blank"> <? php?  _e ( 'Selector de Color' );  ?> </a> </ span>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'Mostrar nombre y fotografía de autor' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_show_author" = "checkbox" id = "cff_show_author" <? php  si ( $ cff_show_author  ==  cierto )  echo  "verificado" ;  ?> />
                            <Label for = "cff_show_status_type"> Sí </ label>
                            <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Esto mostrará la imagen en miniatura y el nombre del autor puesto en la parte superior de cada poste' ) ;  ?> </ yo>
                            
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php  _e ( 'Agregar clase CSS para alimentar' );  ?> </ th>
                        <Td>
                            <Input name = tipo "cff_class" = "text" value = " <? php?  esc_attr_e (  $ cff_class  );  ?> "size =" 25 "/>
                            <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Para añadir varias clases separadas cada uno con un espacio, Ej ClassOne classtwo classthree.' );  ?> </ yo>
                        </ Td>
                    </ Tr>
                </ Tbody>
            </ Table>
            
            <Hr />
            <Table class = "forma-mesa">
                <Tbody>
                    <H3> <? php  _E ( 'Post Tipos' );  ?> </ h3>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php  _e ( 'Sólo mostrar este tipo de mensajes:' );  ?> <br />
                            <I style = "color: # 666; font-size: 11px;"> <a target="_blank"> href="http://smashballoon.com/custom-facebook-feed/" <? php?  _e ( ' Actualiza a Pro para permitir que los tipos de correos, fotos, videos y más " );  ?> </a> </ i> </ th>
                        <Td>
                            <Div>
                                <Input name = tipo "cff_show_status_type" = "checkbox" id = "cff_show_status_type" discapacitado comprobado />
                                <Label for = "cff_show_status_type"> <? php?  _e ( 'Los estados' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_event_type" id = "cff_show_event_type" discapacitado comprobado />
                                <Label for = "cff_show_event_type"> <? php?  _e ( 'Eventos' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_photos_type" id = "cff_show_photos_type" discapacitado comprobado />
                                <Label for = "cff_show_photos_type"> <? php?  _e ( 'Fotos' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_video_type" id = "cff_show_video_type" discapacitado comprobado />
                                <Label for = "cff_show_video_type"> <? php?  _e ( 'Videos' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_links_type" id = "cff_show_links_type" discapacitado comprobado />
                                <Label for = "cff_show_links_type"> <? php?  _E ( 'Enlaces' );  ?> </ label>
                            </ Div>
                        </ Td>
                    </ Tr>
                </ Tbody>
            </ Table>
            <? Php  submit_button ();  ?>
            
            <a href="http://smashballoon.com/custom-facebook-feed/demo" target="_blank"> <img src = " <? php  echo  plugins_url () .  '/ wp-facebook-alimentación / img / pro.png ' ; ?> "/> </a>
            <? Php  }  // ficha General Fin?>
            <? php  si (  $ active_tab  ==  'post_layout'  )  {  // pestaña Inicio Publicar Diseño?>
            < input  tipo = "oculto"  nombre = "<? php echo? $ style_post_layout_hidden_field_name ;?> "  valor = "Y" >
            < br  />
            < h3 > <? php  _e ( 'Publicar Layout' );  ?> </ h3>
            <Table class = "forma-mesa">
                <Tbody>
                    <Tr>
                        <Td> <p> <? php?  _e ( 'Elegir un diseño de la 3 a continuación:' );  ?> </ p> </ td>
                        <Td>
                            <Select name = "cff_preset_layout" desactivado>
                                <Option value = "pulgar"> <? php  _e ( 'miniatura' );  ?> </ option>
                                <Option value = "media"> <? php?  _e ( 'Half-width' );  ?> </ option>
                                <Option value = "completa"> <? php?  _e ( 'Full-width' );  ?> </ option>
                            </ Select>
                            <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <a href="http://smashballoon.com/custom-facebook-feed/" target="_blank"> <? php  _e ( 'Actualizar a Pro para permitir colocar nuestros diseños' );  ?> </a> </ i>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'Miniatura:' );  ?> </ th>
                        <Td>
                            <Img src = " <? php  echo  plugins_url () .  '/wp-facebook-feed/img/layout-thumb.png' ;  >? "alt = width = estilo" miniatura Diseño "" 400px "=" border: 1px #ccc sólido; " />
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'Half-width:' );  ?> </ th>
                        <Td>
                            <Img src = " <? php  echo  plugins_url () .  '/wp-facebook-feed/img/layout-half.png' ;  ?> "alt = width = estilo de" La mitad del ancho de diseño "" 400px "=" border: 1px #ccc sólido; " />
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php?  _e ( 'de ancho completo:' );  ?> </ th>
                        <Td>
                            <Img src = " <? php  echo  plugins_url () .  '/wp-facebook-feed/img/layout-full.png' ;  ?> "alt = width = estilo" Ancho Completo Diseño "" 400px "=" border: 1px #ccc sólido; " />
                        </ Td>
                    </ Tr>
                    </ Tbody>
                </ Table>
                <Hr />
                <H3> <? php  _e ( 'Mostrar / Ocultar' );  ?> </ h3>
                <Table class = "forma-mesa">
                    <Tbody>
                    <Tr valign = "top">
                        <Th scope = "row"> <? php  _e ( 'Incluir lo siguiente en los mensajes:' );  ?> <br /> <? php  _e ( '(en su caso)' );  ?>
                            <br /> <i estilo = "color: # 666; font-size: 11px;"> <a target="_blank"> href="http://smashballoon.com/custom-facebook-feed/" <? php  _e ( 'Actualiza a Pro para permitir que todas estas opciones' );  ?> </a> </ i> </ th>
                        <Td>
                            <Div>
                                <Input name = tipo "cff_show_text" = "checkbox" id = "cff_show_text" <? php  si ( $ cff_show_text  ==  cierto )  echo  "verificado" ;  ?> />
                                <Label for = "cff_show_text"> <? php?  _e ( 'texto del anuncio' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_date" id = "cff_show_date" <? php  si ( $ cff_show_date  ==  cierto )  echo  'comprueba = "comprobado"'  ?> />
                                <Label for = "cff_show_date"> <? php?  _e ( 'Fecha' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" id = "cff_show_media" discapacitados />
                                <Label for = "cff_show_media"> <? php?  _e ( 'Fotos / videos' );  ?> </ label>
                            </ Div>
                            <Div>
                                <input type = "checkbox" name = "cff_show_shared_links" id = "cff_show_shared_links" <? php  si ( cff_show_shared_links $  ==  cierto )  de eco  'comprueban = "comprobado"'  ?> />
                                <Label for = "cff_show_shared_links"> <? php?  _E ( 'enlaces compartidos' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_desc" id = "cff_show_desc" <? php  si ( $ cff_show_desc  ==  cierto )  echo  'comprueba = "comprobado"'  ?> />
                                <Label for = "cff_show_desc"> <? php?  _E ( 'Link, foto y video descripciones' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_event_title" id = "cff_show_event_title" <? php  si ( $ cff_show_event_title  ==  cierto )  echo  'comprueba = "comprobado"'  ?> />
                                <Label for = "cff_show_event_title"> <? php?  _e ( 'Título del evento' );  ?> </ label>
                            </ Div>
                            <Div>
                                <input type = "checkbox" name = "cff_show_event_details" id = "cff_show_event_details" <? php  si ( cff_show_event_details $  ==  cierto )  de eco  'comprueban = "comprobado"'  ?> />
                                <Label for = "cff_show_event_details"> <? php?  _E ( 'Detalles del evento' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" id = "cff_show_meta" discapacitados />
                                <Label for = "cff_show_meta"> <? php?  _e ( 'gusta / acciones / comentarios' );  ?> </ label>
                            </ Div>
                            <Div>
                                <Input type = "checkbox" name = "cff_show_link" id = "cff_show_link" <? php  si ( $ cff_show_link  ==  cierto )  echo  'comprueba = "comprobado"'  ?> />
                                <Label for = "cff_show_link"> <? php?  _e ( 'Ver en Facebook / Ver Enlace' );  ?> </ label>
                            </ Div>
                        </ Td>
                    </ Tr>
                </ Tbody>
            </ Table>
            
            <? Php  submit_button ();  ?>
            <a href="http://smashballoon.com/custom-facebook-feed/demo" target="_blank"> <img src = " <? php  echo  plugins_url () . '/ wp-facebook-alimentación / img / pro.png ' ;  ?> "/> </a>
            <? Php  }  // Fin Publicar pestaña Layout?>
            <? php  si (  $ active_tab  ==  'tipografía'  )  {  // Inicia ficha Tipografía?>
            < input  tipo = "oculto"  nombre = "<? php echo? $ style_typography_hidden_field_name ;?> "  valor = "Y" >
            < br  />
            < h3 <?> php  _e ( 'Tipografía' );  ?> </ h3>
            <P> <i style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( '"Heredar" significa que el texto va a heredar los estilos de su tema.' ) ;  ?> </ i> </ p>
            <Div id = "poststuff" class = "METABOX titular">
                <div class = "meta-caja-sortables ui-ordenables">
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <h3 class = "hndle"> <span> <? php  _E ( 'Límites de caracteres de texto' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                                <Tr valign = "top">
                                    <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Máximo Publicar Longitud del texto' );  ?> </ label> </ th>
                                    <Td>
                                        <Input name = tipo "cff_title_length" = "text" value = " <? php?  esc_attr_e (  $ cff_title_length_val  );  ?> "size =" 4 "/> <span> <? php?  _e ( 'Caracteres.' );  ?> </ span> <span> Ej. 200 </ span> <i style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Si el texto excede esta longitud puesto luego un botón "Más Ver" será añadir Dejar en blanco para establecer ninguna longitud máxima '.. );  ?> </ i>
                                    </ Td>
                                </ Tr>
                                <Tr valign = "top">
                                    <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Descripción Longitud máxima' );  ?> </ th> </ label>
                                    <Td>
                                        <Input name = tipo "cff_body_length" = "text" value = " <? php?  esc_attr_e (  $ cff_body_length_val  );  ?> "size =" 4 "/> <span> <? php?  _e ( 'Caracteres.' );  ?> </ span> <i style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Dejar en blanco para establecer ninguna longitud máxima' );  ?> </ i>
                                    </ Td>
                                </ Tr>
                                <Tr>
                                    <Th> <label for = clase "cff_see_more_text" = "bump-left"> <? php  _e ( 'personalizado "Conozca más" texto' );  ?> </ label> </ th>
                                    <Td>
                                        <Input name = tipo "cff_see_more_text" = "text" value = " <? php?  esc_attr_e (  $ cff_see_more_text  );  ?> "size =" 20 "/>
                                        <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Use un texto diferente en lugar de la opción predeterminada "Conozca más" texto' );  ?> </ yo>
                                    </ Td>
                                </ Tr>
                                <Tr>
                                    <Th> <label for = clase "cff_see_less_text" = "bump-left"> <? php  _e ( 'personalizado "Ver Menos" texto' );  ?> </ label> </ th>
                                    <Td>
                                        <Input name = tipo "cff_see_less_text" = "text" value = " <? php?  esc_attr_e (  $ cff_see_less_text  );  ?> "size =" 20 "/>
                                        <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Use un texto diferente en lugar de la opción predeterminada "Ver Menos" texto' );  ?> </ yo>
                                    </ Td>
                                </ Tr>
                            </ Tbody>
                        </ Table>
                    </ Div>
                </ Div>
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <H3 class = "hndle"> <span> <? php?  _e ( 'Post texto' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                                <Tr>
                                    <Th> <label for = clase "cff_title_format" = "Bump-izquierda"> <? php?  _e ( 'Formato' );  ?> </ label> </ th>
                                    <Td>
                                        <Select name = "cff_title_format">
                                            <Option value = "p" <? php  si ( $ cff_title_format  ==  "p" )  echo  "selected =" selected ""  ?> > Párrafo </ option>
                                            <Option value = "h3" <? php  si ( $ cff_title_format  ==  "h3" )  echo  "selected =" selected ""  ?> > rúbrica 3 </ option>
                                            <Option value = "h4" <? php  si ( $ cff_title_format  ==  "h4" )  echo  "selected =" selected ""  ?> > Rúbrica 4 </ option>
                                            <Option value = "h5" <? php  si ( $ cff_title_format  ==  "h5" )  echo  "selected =" selected ""  ?> > Rúbrica 5 </ option>
                                            <Option value = "h6" <? php  si ( $ cff_title_format  ==  "h6" )  echo  "selected =" selected ""  ?> > Título 6 </ option>
                                        </ Select>
                                    </ Td>
                                </ Tr>
                                <Tr>
                                    <Th> <label for = clase "cff_title_size" = "bump-left"> <? php?  _e ( 'Tamaño de texto' );  ?> </ th> </ label>
                                    <Td>
                                        <Select name = "cff_title_size">
                                            <Option value = "heredar" <? php  si ( $ cff_title_size  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                            <Option value = "10" <? php  si ( $ cff_title_size  ==  "10" )  echo  "selected =" selected ""  ?> > 10px </ option>
                                            <Option value = "11" <? php  si ( $ cff_title_size  ==  "11" )  echo  "selected =" selected ""  ?> > 11px </ option>
                                            <Option value = "12" <? php  si ( $ cff_title_size  ==  "12" )  echo  "selected =" selected ""  ?> > 12px </ option>
                                            <Option value = "14" <? php  si ( $ cff_title_size  ==  "14" )  echo  "selected =" selected ""  ?> > 14px </ option>
                                            <Option value = "16" <? php  si ( $ cff_title_size  ==  "16" )  echo  "selected =" selected ""  ?> > 16px </ option>
                                            <Option value = "18" <? php  si ( $ cff_title_size  ==  "18" )  echo  "selected =" selected ""  ?> > 18px </ option>
                                            <Option value = "20" <? php  si ( $ cff_title_size  ==  "20" )  echo  "selected =" selected ""  ?> > 20px </ option>
                                            <Option value = "24" <? php  si ( $ cff_title_size  ==  "24" )  echo  "selected =" selected ""  ?> > 24px </ option>
                                            <Option value = "28" <? php  si ( $ cff_title_size  ==  "28" )  echo  "selected =" selected ""  ?> > 28px </ option>
                                            <Option value = "32" <? php  si ( $ cff_title_size  ==  "32" )  echo  "selected =" selected ""  ?> > 32px </ option>
                                            <Option value = "36" <? php  si ( $ cff_title_size  ==  "36" )  echo  "selected =" selected ""  ?> > 36px </ option>
                                            <Option value = "42" <? php  si ( $ cff_title_size  ==  "42" )  echo  "selected =" selected ""  ?> > 42px </ option>
                                            <Option value = "48" <? php  si ( $ cff_title_size  ==  "48" )  echo  "selected =" selected ""  ?> > 48px </ option>
                                            <Option value = "60" <? php  si ( $ cff_title_size  ==  "54" )  echo  "selected =" selected ""  ?> > 54px </ option>
                                            <Option value = "60" <? php  si ( $ cff_title_size  ==  "60" )  echo  "selected =" selected ""  ?> > 60px </ option>
                                        </ Select>
                                    </ Td>
                                </ Tr>
                                <Tr>
                                    <Th> <label for = clase "cff_title_weight" = "bump-left"> <? php?  _e ( 'Peso del texto' );  ?> </ th> </ label>
                                    <Td>
                                        <Select name = "cff_title_weight">
                                            <Option value = "heredar" <? php  si ( $ cff_title_weight  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                            <Option value = "normal" <? php  si ( $ cff_title_weight  ==  "normal" )  echo  "selected =" selected ""  ?> > Normal </ option>
                                            <Option value = "negrita" <? php  si ( $ cff_title_weight  ==  "negrita" )  echo  "selected =" selected ""  ?> > negrita </ option>
                                        </ Select>
                                    </ Td>
                                </ Tr>
                                <Tr>
                                    <Th> <label for = clase "cff_title_color" = "bump-left"> <? php?  _e ( 'Color del texto' );  ?> </ label> </ th>
                                    <Td>
                                        # <Input name = tipo "cff_title_color" = "text" value = " <? php?  esc_attr_e (  $ cff_title_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                                        <Span> <a href="http://www.colorpicker.com/" target="_blank"> <? php?  _e ( 'Selector de Color' );  ?> </a> </ span>
                                    </ Td>
                                </ Tr>
                                <Tr>
                                    <Th> <label for = "cff_title_link" class = "bump-left"> <? php?  _e ( 'Enlace de texto a mensaje de Facebook?' );  ?> </ label> </ th>
                                    <Td> <input type = "checkbox" name = id "cff_title_link" = "cff_title_link" <? php  si ( $ cff_title_link  ==  cierto )  echo  'comprueba = "comprobado"'  >? /> & nbsp; Sí </ td>
                                </ Tr>
                                
                                </ Tbody>
                            </ Table>
                        </ Div>
                </ Div>
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <H3 class = "hndle"> <span> <? php?  _e ( 'Link, Foto y Video Descripción' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                            
                            <Tr>
                                <Th> <label for = clase "cff_body_size" = "bump-left"> <? php?  _e ( 'Tamaño de texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_body_size">
                                        <Option value = "heredar" <? php  si ( $ cff_body_size  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "10" <? php  si ( $ cff_body_size  ==  "10" )  echo  "selected =" selected ""  ?> > 10px </ option>
                                        <Option value = "11" <? php  si ( $ cff_body_size  ==  "11" )  echo  "selected =" selected ""  ?> > 11px </ option>
                                        <Option value = "12" <? php  si ( $ cff_body_size  ==  "12" )  echo  "selected =" selected ""  ?> > 12px </ option>
                                        <Option value = "14" <? php  si ( $ cff_body_size  ==  "14" )  echo  "selected =" selected ""  ?> > 14px </ option>
                                        <Option value = "16" <? php  si ( $ cff_body_size  ==  "16" )  echo  "selected =" selected ""  ?> > 16px </ option>
                                        <Option value = "18" <? php  si ( $ cff_body_size  ==  "18" )  echo  "selected =" selected ""  ?> > 18px </ option>
                                        <Option value = "20" <? php  si ( $ cff_body_size  ==  "20" )  echo  "selected =" selected ""  ?> > 20px </ option>
                                        <Option value = "24" <? php  si ( $ cff_body_size  ==  "24" )  echo  "selected =" selected ""  ?> > 24px </ option>
                                        <Option value = "28" <? php  si ( $ cff_body_size  ==  "28" )  echo  "selected =" selected ""  ?> > 28px </ option>
                                        <Option value = "32" <? php  si ( $ cff_body_size  ==  "32" )  echo  "selected =" selected ""  ?> > 32px </ option>
                                        <Option value = "36" <? php  si ( $ cff_body_size  ==  "36" )  echo  "selected =" selected ""  ?> > 36px </ option>
                                        <Option value = "42" <? php  si ( $ cff_body_size  ==  "42" )  echo  "selected =" selected ""  ?> > 42px </ option>
                                        <Option value = "48" <? php  si ( $ cff_body_size  ==  "48" )  echo  "selected =" selected ""  ?> > 48px </ option>
                                        <Option value = "60" <? php  si ( $ cff_body_size  ==  "54" )  echo  "selected =" selected ""  ?> > 54px </ option>
                                        <Option value = "60" <? php  si ( $ cff_body_size  ==  "60" )  echo  "selected =" selected ""  ?> > 60px </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_body_weight" = "bump-left"> <? php?  _e ( 'Peso del texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_body_weight">
                                        <Option value = "heredar" <? php  si ( $ cff_body_weight  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "normal" <? php  si ( $ cff_body_weight  ==  "normal" )  echo  "selected =" selected ""  ?> > Normal </ option>
                                        <Option value = "negrita" <? php  si ( $ cff_body_weight  ==  "negrita" )  echo  "selected =" selected ""  ?> > negrita </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_body_color" = "bump-left"> <? php?  _e ( 'Color del texto' );  ?> </ label> </ th>
                                
                                <Td>
                                    # <Input name = tipo "cff_body_color" = "text" value = " <? php?  esc_attr_e (  $ cff_body_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                                    <a href="http://www.colorpicker.com/" target="_blank"> <? php  _e ( 'Selector de Color' );  ?> </a>
                                </ Td>
                            </ Tr>
                            </ Tbody>
                        </ Table>
                    </ Div>
                </ Div>
            <Div style = "margin-top: -15px;">
                <? Php  submit_button ();  ?>
            </ Div>
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <H3 class = "hndle"> <span> <? php?  _e ( 'Fecha' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                            <Tr>
                                <Th> <label for = clase "cff_date_position" = "Bump-izquierda"> <? php?  _e ( 'Posición' );  ?> </ label> </ th>
                                <Td>
                                    <Select name = "cff_date_position">
                                        <Option value = "debajo de" <? php  si ( $ cff_date_position  ==  "abajo" )  echo  "selected =" selected ""  ?> > A continuación texto </ option>
                                        <Option value = "por encima de" <? php  si ( $ cff_date_position  ==  "por encima" )  echo  "selected =" selected ""  ?> > Por encima de Texto </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_date_size" = "bump-left"> <? php?  _e ( 'Tamaño de texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_date_size">
                                        <Option value = "heredar" <? php  si ( $ cff_date_size  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "10" <? php  si ( $ cff_date_size  ==  "10" )  echo  "selected =" selected ""  ?> > 10px </ option>
                                        <Option value = "11" <? php  si ( $ cff_date_size  ==  "11" )  echo  "selected =" selected ""  ?> > 11px </ option>
                                        <Option value = "12" <? php  si ( $ cff_date_size  ==  "12" )  echo  "selected =" selected ""  ?> > 12px </ option>
                                        <Option value = "14" <? php  si ( $ cff_date_size  ==  "14" )  echo  "selected =" selected ""  ?> > 14px </ option>
                                        <Option value = "16" <? php  si ( $ cff_date_size  ==  "16" )  echo  "selected =" selected ""  ?> > 16px </ option>
                                        <Option value = "18" <? php  si ( $ cff_date_size  ==  "18" )  echo  "selected =" selected ""  ?> > 18px </ option>
                                        <Option value = "20" <? php  si ( $ cff_date_size  ==  "20" )  echo  "selected =" selected ""  ?> > 20px </ option>
                                        <Option value = "24" <? php  si ( $ cff_date_size  ==  "24" )  echo  "selected =" selected ""  ?> > 24px </ option>
                                        <Option value = "28" <? php  si ( $ cff_date_size  ==  "28" )  echo  "selected =" selected ""  ?> > 28px </ option>
                                        <Option value = "32" <? php  si ( $ cff_date_size  ==  "32" )  echo  "selected =" selected ""  ?> > 32px </ option>
                                        <Option value = "36" <? php  si ( $ cff_date_size  ==  "36" )  echo  "selected =" selected ""  ?> > 36px </ option>
                                        <Option value = "42" <? php  si ( $ cff_date_size  ==  "42" )  echo  "selected =" selected ""  ?> > 42px </ option>
                                        <Option value = "48" <? php  si ( $ cff_date_size  ==  "48" )  echo  "selected =" selected ""  ?> > 48px </ option>
                                        <Option value = "60" <? php  si ( $ cff_date_size  ==  "54" )  echo  "selected =" selected ""  ?> > 54px </ option>
                                        <Option value = "60" <? php  si ( $ cff_date_size  ==  "60" )  echo  "selected =" selected ""  ?> > 60px </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_date_weight" = "bump-left"> <? php?  _e ( 'Peso del texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_date_weight">
                                        <Option value = "heredar" <? php  si ( $ cff_date_weight  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "normal" <? php  si ( $ cff_date_weight  ==  "normal" )  echo  "selected =" selected ""  ?> > Normal </ option>
                                        <Option value = "negrita" <? php  si ( $ cff_date_weight  ==  "negrita" )  echo  "selected =" selected ""  ?> > negrita </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_date_color" = "bump-left"> <? php?  _e ( 'Color del texto' );  ?> </ label> </ th>
                                <Td>
                                    # <Input name = tipo "cff_date_color" = "text" value = " <? php?  esc_attr_e (  $ cff_date_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                                    <a href="http://www.colorpicker.com/" target="_blank"> Color Picker </a>
                                </ Td>
                            </ Tr>
                                    
                            <Tr>
                                <Th> <label for = clase "cff_date_formatting" = "bump-left"> <? php?  _e ( 'Fecha de formato' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_date_formatting">
                                        <? Php  $ inicial  =  strtotime ( '2013-07-25T17: 30: 00 + 0000' );  ?>
                                        <Option value = "1" <? php  si ( $ cff_date_formatting  ==  "1" )  echo  "selected =" selected "'  >? > <? php?  _e ( 'Publicado hace 2 días' );  ?> </ option>
                                        <Option value = "2" <? php  si ( $ cff_date_formatting  ==  "2" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'F JS, g: ia' ,  $ inicial );  ?> </ option>
                                        <Option value = "3" <? php  si ( $ cff_date_formatting  ==  "3" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'F Js ,  $ inicial );  ?> </ opción>
                                        <Option value = "4" <? php  si ( $ cff_date_formatting  ==  "4" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'DF Js ,  $ inicial );  ?> </ opción>
                                        <Option value = "5" <? php  si ( $ cff_date_formatting  ==  "5" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'l F Js ,  $ inicial );  ?> < / option>
                                        <Option value = "6" <? php  si ( $ cff_date_formatting  ==  "6" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'DM JS, Y' ,  $ inicial );  ?> </ option>
                                        <Option value = "7" <? php  si ( $ cff_date_formatting  ==  "7" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'l F JS, Y' ,  $ inicial );  ? > </ option>
                                        <Option value = "8" <? php  si ( $ cff_date_formatting  ==  "8" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'l F JS, Y - g: ia' ,  $ originales );  ?> </ option>
                                        <Option value = "9" <? php  si ( $ cff_date_formatting  ==  "9" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( "l M JS," y " ,  original de $ );  ?> </ option>
                                        <Opción value="10" <?php  if ( $cff_date_formatting  ==  "10" )  echo  'selected="selected"'  ?> > <?php  echo  date ( 'mdy' ,  $original );  ?> </option>
                                        <Opción value="11" <?php  if ( $cff_date_formatting  ==  "11" )  echo  'selected="selected"'  ?> > <?php  echo  date ( 'm/d/y' ,  $original );  ?> </option>
                                        <Opción value="12" <?php  if ( $cff_date_formatting  ==  "12" )  echo  'selected="selected"'  ?> > <?php  echo  date ( 'dmy' ,  $original );  ?> </option>
                                        <Opción value="13" <?php  if ( $cff_date_formatting  ==  "13" )  echo  'selected="selected"'  ?> > <?php  echo  date ( 'd/m/y' ,  $original );  ?> </option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_date_custom" = "bump-left"> <? php?  _e ( 'formato personalizado' );  ?> </ th> </ label>
                                <Td>
                                    <Input name = tipo "cff_date_custom" = "text" value = " <? php?  esc_attr_e (  $ cff_date_custom  );  ?> "size =" 10 "marcador de posición =". Por ejemplo, F j, Y "/>
                                    <I style = "color: # 666; font-size: 11px;"> (<a target="_blank"> href="http://smashballoon.com/custom-facebook-feed/docs/date/" < ? php  _e ( 'Ejemplos' );  ?> </a>) </ i>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_date_before" = "bump-left"> <? php?  _e ( 'Texto antes de la fecha' );  ?> </ label> </ th>
                                <Td> <input name = tipo "cff_date_before" = "text" value = " <? php?  esc_attr_e (  $ cff_date_before  );  ?> "size =" 10 "marcador de posición =". Ej Publicado "/> </ td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_date_after" = "bump-left"> <? php?  _e ( 'Texto después de la fecha' );  ?> </ label> </ th>
                                <Td> <input name = tipo "cff_date_after" = "text" value = " <? php?  esc_attr_e (  $ cff_date_after  );  ?> "size = marcador de posición" 10 "=" Por ejemplo, hace. "/> </ td>
                            </ Tr>
                            </ Tbody>
                        </ Table>
                    </ Div>
                </ Div>
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <H3 class = "hndle"> <span> <? php?  _e ( 'Título del evento' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                            
                            <Tr>
                                <Th> <label for = clase "cff_event_title_format" = "Bump-izquierda"> <? php?  _e ( 'Formato' );  ?> </ label> </ th>
                                <Td>
                                    <Select name = "cff_event_title_format">
                                        <Option value = "p" <? php  si ( $ cff_event_title_format  ==  "p" )  echo  "selected =" selected ""  ?> > Párrafo </ option>
                                        <Option value = "h3" <? php  si ( $ cff_event_title_format  ==  "h3" )  echo  "selected =" selected ""  ?> > rúbrica 3 </ option>
                                        <Option value = "h4" <? php  si ( $ cff_event_title_format  ==  "h4" )  echo  "selected =" selected ""  ?> > Rúbrica 4 </ option>
                                        <Option value = "h5" <? php  si ( $ cff_event_title_format  ==  "h5" )  echo  "selected =" selected ""  ?> > Rúbrica 5 </ option>
                                        <Option value = "h6" <? php  si ( $ cff_event_title_format  ==  "h6" )  echo  "selected =" selected ""  ?> > Título 6 </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            
                            <Tr>
                                <Th> <label for = clase "cff_event_title_size" = "bump-left"> <? php?  _e ( 'Tamaño de texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_event_title_size">
                                        <Option value = "heredar" <? php  si ( $ cff_event_title_size  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "10" <? php  si ( $ cff_event_title_size  ==  "10" )  echo  "selected =" selected ""  ?> > 10px </ option>
                                        <Option value = "11" <? php  si ( $ cff_event_title_size  ==  "11" )  echo  "selected =" selected ""  ?> > 11px </ option>
                                        <Option value = "12" <? php  si ( $ cff_event_title_size  ==  "12" )  echo  "selected =" selected ""  ?> > 12px </ option>
                                        <Option value = "14" <? php  si ( $ cff_event_title_size  ==  "14" )  echo  "selected =" selected ""  ?> > 14px </ option>
                                        <Option value = "16" <? php  si ( $ cff_event_title_size  ==  "16" )  echo  "selected =" selected ""  ?> > 16px </ option>
                                        <Option value = "18" <? php  si ( $ cff_event_title_size  ==  "18" )  echo  "selected =" selected ""  ?> > 18px </ option>
                                        <Option value = "20" <? php  si ( $ cff_event_title_size  ==  "20" )  echo  "selected =" selected ""  ?> > 20px </ option>
                                        <Option value = "24" <? php  si ( $ cff_event_title_size  ==  "24" )  echo  "selected =" selected ""  ?> > 24px </ option>
                                        <Option value = "28" <? php  si ( $ cff_event_title_size  ==  "28" )  echo  "selected =" selected ""  ?> > 28px </ option>
                                        <Option value = "32" <? php  si ( $ cff_event_title_size  ==  "32" )  echo  "selected =" selected ""  ?> > 32px </ option>
                                        <Option value = "36" <? php  si ( $ cff_event_title_size  ==  "36" )  echo  "selected =" selected ""  ?> > 36px </ option>
                                        <Option value = "42" <? php  si ( $ cff_event_title_size  ==  "42" )  echo  "selected =" selected ""  ?> > 42px </ option>
                                        <Option value = "48" <? php  si ( $ cff_event_title_size  ==  "48" )  echo  "selected =" selected ""  ?> > 48px </ option>
                                        <Option value = "60" <? php  si ( $ cff_event_title_size  ==  "54" )  echo  "selected =" selected ""  ?> > 54px </ option>
                                        <Option value = "60" <? php  si ( $ cff_event_title_size  ==  "60" )  echo  "selected =" selected ""  ?> > 60px </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_event_title_weight" = "bump-left"> <? php?  _e ( 'Peso del texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_event_title_weight">
                                        <Opción value="inherit" <?php  if ( $cff_event_title_weight  ==  "inherit" )  echo  'selected="selected"'  ?> >Inherit</option>
                                        <Option value = "normal" <? php  si ( $ cff_event_title_weight  ==  "normal" )  echo  "selected =" selected ""  ?> > Normal </ option>
                                        <Option value = "negrita" <? php  si ( $ cff_event_title_weight  ==  "negrita" )  echo  "selected =" selected ""  ?> > negrita </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_event_title_color" = "bump-left"> <? php?  _e ( 'Color del texto' );  ?> </ label> </ th>
                                <Td>
                                    <Input name = tipo "cff_event_title_color" = "text" value = " <? php?  esc_attr_e (  $ cff_event_title_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                                    <a href="http://www.colorpicker.com/" target="_blank"> <? php  _e ( 'Selector de Color' );  ?> </a>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = "cff_title_link" class = "bump-left"> <? php?  _e ( 'Enlace título a la página del evento en Facebook?' );  ?> </ label> </ th>
                                <Td> <input type = "checkbox" name = "cff_event_title_link" id="cff_event_title_link" <?php  if ( $cff_event_title_link  ==  true )  echo  'checked="checked"'  ?> /> Yes</td>
                            </ Tr>
                            </ Tbody>
                        </ Table>
                    </ Div>
                </ Div>
                <Div style = "margin-top: -15px;">
                    <? Php  submit_button ();  ?>
                </ Div>
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <H3 class = "hndle"> <span> <? php?  _e ( "Fecha Evento ' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                            
                            <Tr>
                                <Th> <label for = clase "cff_event_date_size" = "bump-left"> <? php?  _e ( 'Tamaño de texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_event_date_size">
                                        <Option value = "heredar" <? php  si ( $ cff_event_date_size  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "10" <? php  si ( $ cff_event_date_size  ==  "10" )  echo  "selected =" selected ""  ?> > 10px </ option>
                                        <Option value = "11" <? php  si ( $ cff_event_date_size  ==  "11" )  echo  "selected =" selected ""  ?> > 11px </ option>
                                        <Option value = "12" <? php  si ( $ cff_event_date_size  ==  "12" )  echo  "selected =" selected ""  ?> > 12px </ option>
                                        <Option value = "14" <? php  si ( $ cff_event_date_size  ==  "14" )  echo  "selected =" selected ""  ?> > 14px </ option>
                                        <Option value = "16" <? php  si ( $ cff_event_date_size  ==  "16" )  echo  "selected =" selected ""  ?> > 16px </ option>
                                        <Option value = "18" <? php  si ( $ cff_event_date_size  ==  "18" )  echo  "selected =" selected ""  ?> > 18px </ option>
                                        <Option value = "20" <? php  si ( $ cff_event_date_size  ==  "20" )  echo  "selected =" selected ""  ?> > 20px </ option>
                                        <Option value = "24" <? php  si ( $ cff_event_date_size  ==  "24" )  echo  "selected =" selected ""  ?> > 24px </ option>
                                        <Option value = "28" <? php  si ( $ cff_event_date_size  ==  "28" )  echo  "selected =" selected ""  ?> > 28px </ option>
                                        <Option value = "32" <? php  si ( $ cff_event_date_size  ==  "32" )  echo  "selected =" selected ""  ?> > 32px </ option>
                                        <Option value = "36" <? php  si ( $ cff_event_date_size  ==  "36" )  echo  "selected =" selected ""  ?> > 36px </ option>
                                        <Option value = "42" <? php  si ( $ cff_event_date_size  ==  "42" )  echo  "selected =" selected ""  ?> > 42px </ option>
                                        <Option value = "48" <? php  si ( $ cff_event_date_size  ==  "48" )  echo  "selected =" selected ""  ?> > 48px </ option>
                                        <Option value = "60" <? php  si ( $ cff_event_date_size  ==  "54" )  echo  "selected =" selected ""  ?> > 54px </ option>
                                        <Option value = "60" <? php  si ( $ cff_event_date_size  ==  "60" )  echo  "selected =" selected ""  ?> > 60px </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_event_date_weight" = "bump-left"> <? php?  _e ( 'Peso del texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_event_date_weight">
                                        <Opción value="inherit" <?php  if ( $cff_event_date_weight  ==  "inherit" )  echo  'selected="selected"'  ?> >Inherit</option>
                                        <Option value = "normal" <? php  si ( $ cff_event_date_weight  ==  "normal" )  echo  "selected =" selected ""  ?> > Normal </ option>
                                        <Option value = "negrita" <? php  si ( $ cff_event_date_weight  ==  "negrita" )  echo  "selected =" selected ""  ?> > negrita </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_event_date_color" = "bump-left"> <? php?  _e ( 'Color del texto' );  ?> </ label> </ th>
                                <Td>
                                    # <Input name = tipo "cff_event_date_color" = "text" value = " <? php?  esc_attr_e (  $ cff_event_date_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                                    <a href="http://www.colorpicker.com/" target="_blank"> <? php  _e ( 'Selector de Color' );  ?> </a>
                                </ Td>
                            </ Tr>
                            <Tr valign = "top">
                                <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Fecha Posición' );  ?> </ label> </ th>
                                <Td>
                                    <Select name = "cff_event_date_position">
                                        <Option value = "debajo de" <? php  si ( $ cff_event_date_position  ==  "abajo" )  echo  "selected =" selected "'  >? > <? php?  _e ( 'Debajo título del evento' );  ?> </ option>
                                        <Option value = "por encima de" <? php?  si ( $ cff_event_date_position  ==  "por encima" )  echo  "selected =" selected "'  >? > <? php?  _e ( 'título del evento Sobre' );  ?> </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = "cff_event_date_formatting" class = "bump-left"> <? php?  _e ( 'fecha formato Evento' );  ?> </ label> </ th>
                                <Td>
                                    <Select name = "cff_event_date_formatting">
                                        <? Php  $ inicial  =  strtotime ( '2013-07-25T17: 30: 00 + 0000' );  ?>
                                        <Option value = "1" <? php  si ( $ cff_event_date_formatting  ==  "1" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'F j, Y, g: ia' ,  $ originales );  ?> </ option>
                                        <Option value = "2" <? php  si ( $ cff_event_date_formatting  ==  "2" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'F JS, g: ia' ,  $ inicial );  ?> </ option>
                                        <Option value = "3" <? php  si ( $ cff_event_date_formatting  ==  "3" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'g: ia - F Js ,  $ inicial );  ?> </ option>
                                        <Option value = "4" <? php  si ( $ cff_event_date_formatting  ==  "4" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'g: ia, F Js ,  $ inicial );  ?> </ option>
                                        <Option value = "5" <? php  si ( $ cff_event_date_formatting  ==  "5" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'l F jS - g: ia' ,  $ originales ) ;  ?> </ option>
                                        <Option value = "6" <? php  si ( $ cff_event_date_formatting  ==  "6" )  echo  "selected =" selected "'  >? > <? php?  eco  de fecha ( 'jS DM, Y, g: iA' ,  $ originales );  ?> </ option>
                                        <Option value = "7" <? php  si ( $ cff_event_date_formatting  ==  "7" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'l F JS, Y, g: iA' ,  $ originales );  ?> </ option>
                                        <Option value = "8" <? php  si ( $ cff_event_date_formatting  ==  "8" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'l F JS, Y - g: ia' ,  $ originales );  ?> </ option>
                                        <Option value = "9" <? php  si ( $ cff_event_date_formatting  ==  "9" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( "l M JS," y " ,  original de $ );  ?> </ option>
                                        <Option value = "10" <? php  si ( $ cff_event_date_formatting  ==  "10" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'MDY - g: iA' ,  $ inicial );  ? > </ option>
                                        <Option value = "11" <? php  si ( $ cff_event_date_formatting  ==  "11" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'm / d / a, g: ia' ,  $ originales );  ?> </ option>
                                        <Option value = "12" <? php  si ( $ cff_event_date_formatting  ==  "12" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'DMY - g: iA' ,  $ inicial );  ? > </ option>
                                        <Option value = "13" <? php  si ( $ cff_event_date_formatting  ==  "13" )  echo  "selected =" selected "'  >? > <? php?  eco  fecha ( 'd / m / a, g: ia' ,  $ originales );  ?> </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = "cff_event_date_custom" class = "bump-left"> <? php?  _e ( 'formato de fecha personalizada de eventos' );  ?> </ label> </ th>
                                <Td>
                                    <Input name = tipo "cff_event_date_custom" = "text" value = " <? php  esc_attr_e (  $ cff_event_date_custom  );  ?> "size =" 10 "marcador de posición =". Por ejemplo, F j, Y - g: ia "/>
                                    <I style = "color: # 666; font-size: 11px;"> (<a target="_blank"> href="http://smashballoon.com/custom-facebook-feed/docs/date/" < ? php  _e ( 'Ejemplos' );  ?> </a>) </ i>
                                </ Td>
                            </ Tr>
                            </ Tbody>
                        </ Table>
                    </ Div>
                </ Div>
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <H3 class = "hndle"> <span> <? php?  _e ( 'Detalles del evento' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                            
                            <Tr>
                                <Th> <label for = clase "cff_event_details_size" = "bump-left"> <? php?  _e ( 'Tamaño de texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_event_details_size">
                                        <Opción value="inherit" <?php  if ( $cff_event_details_size  ==  "inherit" )  echo  'selected="selected"'  ?> >Inherit</option>
                                        <Option value = "10" <? php  si ( $ cff_event_details_size  ==  "10" )  echo  "selected =" selected ""  ?> > 10px </ option>
                                        <Option value = "11" <? php  si ( $ cff_event_details_size  ==  "11" )  echo  "selected =" selected ""  ?> > 11px </ option>
                                        <Option value = "12" <? php  si ( $ cff_event_details_size  ==  "12" )  echo  "selected =" selected ""  ?> > 12px </ option>
                                        <Option value = "14" <? php  si ( $ cff_event_details_size  ==  "14" )  echo  "selected =" selected ""  ?> > 14px </ option>
                                        <Option value = "16" <? php  si ( $ cff_event_details_size  ==  "16" )  echo  "selected =" selected ""  ?> > 16px </ option>
                                        <Option value = "18" <? php  si ( $ cff_event_details_size  ==  "18" )  echo  "selected =" selected ""  ?> > 18px </ option>
                                        <Option value = "20" <? php  si ( $ cff_event_details_size  ==  "20" )  echo  "selected =" selected ""  ?> > 20px </ option>
                                        <Option value = "24" <? php  si ( $ cff_event_details_size  ==  "24" )  echo  "selected =" selected ""  ?> > 24px </ option>
                                        <Option value = "28" <? php  si ( $ cff_event_details_size  ==  "28" )  echo  "selected =" selected ""  ?> > 28px </ option>
                                        <Option value = "32" <? php  si ( $ cff_event_details_size  ==  "32" )  echo  "selected =" selected ""  ?> > 32px </ option>
                                        <Option value = "36" <? php  si ( $ cff_event_details_size  ==  "36" )  echo  "selected =" selected ""  ?> > 36px </ option>
                                        <Option value = "42" <? php  si ( $ cff_event_details_size  ==  "42" )  echo  "selected =" selected ""  ?> > 42px </ option>
                                        <Option value = "48" <? php  si ( $ cff_event_details_size  ==  "48" )  echo  "selected =" selected ""  ?> > 48px </ option>
                                        <Option value = "60" <? php  si ( $ cff_event_details_size  ==  "54" )  echo  "selected =" selected ""  ?> > 54px </ option>
                                        <Option value = "60" <? php  si ( $ cff_event_details_size  ==  "60" )  echo  "selected =" selected ""  ?> > 60px </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_event_details_weight" = "bump-left"> <? php?  _e ( 'Peso del texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_event_details_weight">
                                        <Opción value="inherit" <?php  if ( $cff_event_details_weight  ==  "inherit" )  echo  'selected="selected"'  ?> >Inherit</option>
                                        <Opción value="normal" <?php  if ( $cff_event_details_weight  ==  "normal" )  echo  'selected="selected"'  ?> >Normal</option>
                                        <Option value = "negrita" <? php  si ( $ cff_event_details_weight  ==  "negrita" )  echo  "selected =" selected ""  ?> > negrita </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_event_details_color" = "bump-left"> <? php?  _e ( 'Color del texto' );  ?> </ label> </ th>
                                <Td>
                                    # <Input name = tipo "cff_event_details_color" = "text" value = " <? php?  esc_attr_e (  $ cff_event_details_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                                    <a href="http://www.colorpicker.com/" target="_blank"> <? php  _e ( 'Selector de Color' );  ?> </a>
                                </ Td>
                            </ Tr>
                            </ Tbody>
                        </ Table>
                    </ Div>
                </ Div>
                <Div id = "adminform" class = estilo de "buzón de correos" = "display: block;">
                    <Div class = título "handlediv" = "Haga clic para activar"> <br> </ div>
                    <H3 class = "hndle"> <span> <? php?  _e ( 'Enlace a Facebook' );  ?> </ span> </ h3>
                    <Div class = "dentro">
                        <Table class = "forma-mesa">
                            <Tbody>
                                
                            <Tr>
                                <Th> <label for = clase "cff_link_size" = "bump-left"> <? php?  _e ( 'Tamaño de texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_link_size">
                                        <Option value = "heredar" <? php  si ( $ cff_link_size  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "10" <? php  si ( $ cff_link_size  ==  "10" )  echo  "selected =" selected ""  ?> > 10px </ option>
                                        <Option value = "11" <? php  si ( $ cff_link_size  ==  "11" )  echo  "selected =" selected ""  ?> > 11px </ option>
                                        <Option value = "12" <? php  si ( $ cff_link_size  ==  "12" )  echo  "selected =" selected ""  ?> > 12px </ option>
                                        <Option value = "14" <? php  si ( $ cff_link_size  ==  "14" )  echo  "selected =" selected ""  ?> > 14px </ option>
                                        <Option value = "16" <? php  si ( $ cff_link_size  ==  "16" )  echo  "selected =" selected ""  ?> > 16px </ option>
                                        <Option value = "18" <? php  si ( $ cff_link_size  ==  "18" )  echo  "selected =" selected ""  ?> > 18px </ option>
                                        <Option value = "20" <? php  si ( $ cff_link_size  ==  "20" )  echo  "selected =" selected ""  ?> > 20px </ option>
                                        <Option value = "24" <? php  si ( $ cff_link_size  ==  "24" )  echo  "selected =" selected ""  ?> > 24px </ option>
                                        <Option value = "28" <? php  si ( $ cff_link_size  ==  "28" )  echo  "selected =" selected ""  ?> > 28px </ option>
                                        <Option value = "32" <? php  si ( $ cff_link_size  ==  "32" )  echo  "selected =" selected ""  ?> > 32px </ option>
                                        <Option value = "36" <? php  si ( $ cff_link_size  ==  "36" )  echo  "selected =" selected ""  ?> > 36px </ option>
                                        <Option value = "42" <? php  si ( $ cff_link_size  ==  "42" )  echo  "selected =" selected ""  ?> > 42px </ option>
                                        <Option value = "48" <? php  si ( $ cff_link_size  ==  "48" )  echo  "selected =" selected ""  ?> > 48px </ option>
                                        <Option value = "60" <? php  si ( $ cff_link_size  ==  "54" )  echo  "selected =" selected ""  ?> > 54px </ option>
                                        <Option value = "60" <? php  si ( $ cff_link_size  ==  "60" )  echo  "selected =" selected ""  ?> > 60px </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_link_weight" = "bump-left"> <? php?  _e ( 'Peso del texto' );  ?> </ th> </ label>
                                <Td>
                                    <Select name = "cff_link_weight">
                                        <Option value = "heredar" <? php  si ( $ cff_link_weight  ==  "heredar" )  echo  "selected =" selected ""  ?> > Heredar </ option>
                                        <Option value = "normal" <? php  si ( $ cff_link_weight  ==  "normal" )  echo  "selected =" selected ""  ?> > Normal </ option>
                                        <Option value = "negrita" <? php  si ( $ cff_link_weight  ==  "negrita" )  echo  "selected =" selected ""  ?> > negrita </ option>
                                    </ Select>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_link_color" = "bump-left"> <? php?  _e ( 'Color del texto' );  ?> </ label> </ th>
                                <Td>
                                    <Input name = tipo "cff_link_color" = "text" value = " <? php?  esc_attr_e (  $ cff_link_color  );  ?> "size =" 10 "marcador de posición =". Por ejemplo ED9A00 "/>
                                    <a href="http://www.colorpicker.com/" target="_blank"> <? php  _e ( 'Selector de Color' );  ?> </a>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_facebook_link_text" = "bump-left"> <? php?  _e ( '"Vista en Facebook" Custom texto' );  ?> </ label> </ th>
                                <Td>
                                    <Input name = tipo "cff_facebook_link_text" = "text" value = " <? php?  esc_attr_e (  $ cff_facebook_link_text  );  ?> "size =" 20 "/>
                                    <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Use un texto diferente en lugar de la opción predeterminada "Ver en Facebook" enlace " );  ?> < / yo>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_view_link_text" = "bump-left"> <? php?  _e ( "Custom" Ver Enlace "texto ' );  ?> </ label> </ th>
                                <Td>
                                    <Input name = tipo "cff_view_link_text" = "text" value = " <? php?  esc_attr_e (  $ cff_view_link_text  );  ?> "size =" 20 "/>
                                    <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Use un texto diferente en lugar de la opción predeterminada "Ver en Facebook" enlace " );  ?> < / yo>
                                </ Td>
                            </ Tr>
                            <Tr>
                                <Th> <label for = clase "cff_link_to_timeline" = "bump-left"> <? php?  _E ( 'Enlace estados a su página' );  ?> </ th> </ label>
                                <Td>
                                    <Input type = "checkbox" name = id "cff_link_to_timeline" = "cff_link_to_timeline" <? php  si ( $ cff_link_to_timeline  ==  cierto )  echo  'comprueba = "comprobado"'  >? /> & nbsp; Sí
                                    <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( "Check this si desea vincular los estados a su línea de tiempo / página de Facebook en lugar de a su mensajes individuales en Facebook " );  ?> </ i>
                                </ Td>
                            </ Tr>
                            
                        </ Tbody>
                    </ Table>
                    </ Div>
                </ Div>
                </ Div>
            </ Div>
            <Div style = "margin-top: -15px;">
                <? Php  submit_button ();  ?>
            </ Div>
            <a href="http://smashballoon.com/custom-facebook-feed/demo" target="_blank"> <img src = " <? php  echo  plugins_url () .  '/ wp-facebook-alimentación / img / pro.png ' ; ?> "/> </a>
            
            <? Php  }  // Fin ficha Tipografía?>
            <? php  si (  $ active_tab  ==  'misc'  )  {  // pestaña Inicio Varios?>
            < input  tipo = "oculto"  nombre = "<? php echo? $ style_misc_hidden_field_name ;?> "  valor = "Y" >
            < br  />
            < h3 <?> php  _E ( '¡Bien Acciones y Comentarios' );  ?> </ h3> <i style = "color: # 666; font-size: 11px;"> <a href = "http: // "target =" _ blank smashballoon.com/custom-facebook-feed/ "> <? php?  _e ( 'Actualiza a Pro para permitir gustos, acciones y comentarios' );  ?> </a> </ i>
            
            <Hr />
            <H3> <? php  _e ( 'Custom CSS' );  ?> </ h3>
            <Table class = "forma-mesa">
                <Tbody>
                    <Tr valign = "top">
                        <Td>
                        <? Php  _e ( 'Escriba su propia CSS personalizado en el cuadro de abajo' );  ?>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Td>
                            <Textarea name = "cff_custom_css" id = estilo "cff_custom_css" = "width: 70%;" filas = "7"> <? php  esc_attr_e (  $ cff_custom_css  );  ?> </ textarea>
                        </ Td>
                    </ Tr>
                </ Tbody>
            </ Table>
            <Hr />
            <H3> <? php  _e ( 'Miscelánea' );  ?> </ h3>
            <Table class = "forma-mesa">
                <Tbody>
                    <Tr> <td> <b style = "font-size: 14px;"> <? php  _e ( 'Like Box' );  ?> </ b> </ td> </ tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Mostrar el Box ¿Te gusta' );  ?> </ th> </ label>
                        <Td>
                            <Input type = "checkbox" name = "cff_show_like_box" id = "cff_show_like_box" <? php  si ( $ cff_show_like_box  ==  cierto )  echo  'comprueba = "comprobado"'  ?> />
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Like Box Posición' );  ?> </ label> </ th>
                        <Td>
                            <Select name = "cff_like_box_position">
                                <Opción value="bottom" <?php  if ( $cff_like_box_position  ==  "bottom" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Bottom' );  ?> </option>
                                <Opción value="top" <?php  if ( $cff_like_box_position  ==  "top" )  echo  'selected="selected"'  ?> > <?php  _e ( 'Top' );  ?> </option>
                            </ Select>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Display fuera del área de desplazamiento' );  ?> </ label> </ th>
                        <Td>
                            <Input type = "checkbox" name = "cff_like_box_outside" id = "cff_like_box_outside" <? php  si ( $ cff_like_box_outside  ==  cierto )  echo  'comprueba = "comprobado"'  ?> />
                            <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( '(Sólo aplicable si ha configurado una altura en la alimentación)' );  ?> </ yo>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Like Box Color de fondo' );  ?> </ label> </ th>
                        <Td>
                            <Label for = "cff_likebox_bg_color"> # </ label>
                            <Input name = tipo "cff_likebox_bg_color" = "text" value = " <? php?  esc_attr_e (  $ cff_likebox_bg_color  );  ?> "size =" 10 "/>
                            <Span> Ej. ED9A00 </ span> & nbsp; & nbsp; <a href="http://www.colorpicker.com/" target="_blank"> <? php?  _e ( 'Selector de Color' );  ?> </a>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <label for = clase "cff_likebox_width" = "bump-left"> <? php?  _e ( 'Like Box width' );  ?> </ label> </ th>
                        <Td>
                            <Input name = tipo "cff_likebox_width" = "text" value = " <? php?  esc_attr_e (  $ cff_likebox_width  );  ?> "size =" 6 "/>
                            <Span> px <i style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'El valor predeterminado es 300' );  ?> </ i> </ span>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Mostrar enfrenta en igual Box' );  ?> </ label> </ th>
                        <Td>
                            <input type = "checkbox" name = "cff_like_box_faces" id = "cff_like_box_faces" <? php  si ( cff_like_box_faces $  ==  cierto )  de eco  'comprueban = "comprobado"'  ?> />
                            <I style = "color: # 666; font-size: 11px; margin-left: 5px;"> <? php  _e ( 'Mostrar las fotos en miniatura de los fans que les gusta su página' );  ?> </ i>
                        </ Td>
                    </ Tr>
                    
                    <Tr> <td> <b style = "font-size: 14px;"> <? php  _e ( 'Separación Línea' );  ?> </ b> </ td> </ tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Separación Color Line' );  ?> </ label> </ th>
                        <Td>
                            <Label for = "cff_sep_color"> # </ label>
                            <Input name = tipo "cff_sep_color" = "text" value = " <? php?  esc_attr_e (  $ cff_sep_color  );  ?> "size =" 10 "/>
                            <Span> Ej. ED9A00 </ span> & nbsp; & nbsp; <a href="http://www.colorpicker.com/" target="_blank"> <? php?  _e ( 'Selector de Color' );  ?> </a>
                        </ Td>
                    </ Tr>
                    <Tr valign = "top">
                        <Th scope = "row"> <clase de etiqueta = "bump-left"> <? php?  _e ( 'Separación Grosor de línea' );  ?> </ th> </ label>
                        <Td>
                            <Input name = tipo "cff_sep_size" = "text" value = " <? php  esc_attr_e (  $ cff_sep_size  );  ?> "size =" 1 "/> <span> px </ span> <i style =" color: # 666; font-size: 11px; margin-left: 5px; "> <? php  _e ( '(Dejar en blanco para ocultar)' );  ?> </ i>
                        </ Td>
                    </ Tr>
                </ Tbody>
            </ Table>
            <? Php  submit_button ();  ?>
            <a href="http://smashballoon.com/custom-facebook-feed/demo" target="_blank"> <img src = " <? php  echo  plugins_url () .  '/ wp-facebook-alimentación / img / pro.png ' ;  ?> "/> </a>
            <? Php  }  // Fin pestaña Misc?>
        </ forma >
<? php 
}  // Fin Style_Page
// estilos de administración Encola
función  cff_admin_style ()  {
        wp_register_style (  'custom_wp_admin_css' ,  plugins_url ()  .  '/wp-facebook-feed/css/cff-admin-style.css' ,  false ,  '1.0.0'  );
        wp_enqueue_style (  'custom_wp_admin_css'  );
}
add_action (  'admin_enqueue_scripts' ,  'cff_admin_style'  );
// Encola los scripts de administración
función  cff_admin_scripts ()  {
    wp_enqueue_script (  'cff_admin_script' ,  plugins_url ()  .  '/wp-facebook-feed/js/cff-admin-scripts.js'  );
    wp_enqueue_script (  'hoverIntent'  );
}
add_action (  'admin_enqueue_scripts' ,  'cff_admin_scripts'  );
?>
