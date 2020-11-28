<?php
defined('_JEXEC') or die;

class ModMapaPrevisaoMunicipioHelper
{

    function getUrl($nome, $dadosWS, $municipio = null){
        $url = null;
        $parametroMunicipio = "municipio=1";
        if(!is_null($municipio)){
            $parametroMunicipio = "municipio=$municipio";
        }

        if(strtoupper($nome) == 'LISTA_MUNICIPIOS'){
            $url    = $dadosWS['ip_webservice'] . ":" . $dadosWS['porta_webservice'];
            $url    .= "/BarramentoServicosApac/Servicos/Site/Meteorologia/PrevisaoMunicipios/ServicoGeoJsonMunicipios.php";
        
        }else if(strtoupper($nome) == 'LISTA_PREVISOES'){
            $url    = $dadosWS['ip_webservice'] . ":" . $dadosWS['porta_webservice'];
            $url    .= "/BarramentoServicosApac/Servicos/Site/Meteorologia/PrevisaoMunicipios/Diaria/ServicoListarMunicipios.php?$parametroMunicipio";
        
        }else if(strtoupper($nome) == 'LISTA_PREVISAO_MUNICIPIO'){
            $url    = $dadosWS['ip_webservice'] . ":" . $dadosWS['porta_webservice'];
            $url    .= "/BarramentoServicosApac/Servicos/Site/Meteorologia/PrevisaoMunicipios/Diaria/ServicoListarMunicipios.php?$parametroMunicipio";
        }

        return $url;
    }

    function getDadosMunicipio($dadosWS){
        $conteudoGeoJson = null;
        $urlConsulta = self::getUrl('LISTA_MUNICIPIOS',$dadosWS);

        // echo $urlConsulta;die;
        $conteudoGeoJson = utf8_encode(file_get_contents($urlConsulta));

        return $conteudoGeoJson;
    }

    function getPrevisaoByIdMunicipio($dadosWS, $idMunicipio){
        $conteudoPrevisao = null;
        $previsao = null;
        $urlConsulta = self::getUrl('LISTA_PREVISOES',$dadosWS, $idMunicipio);
        $conteudoPrevisao = file_get_contents($urlConsulta);

        $conteudoPrevisao = json_decode($conteudoPrevisao);

        if(!is_null($conteudoPrevisao)){
            foreach($conteudoPrevisao->previsao_municipios as $conteudo){
                if($conteudo->codigo == trim($idMunicipio)){
                    $auxPrevisao = $conteudo->previsao;
                    if(!empty($auxPrevisao)){
                        $previsao = $auxPrevisao; 
                    }
                    
                    break;
                }
            }
        }
        return $previsao;
    }

    function getMunicipioByLista($listaGeoJson, $codigoIBGE){
        // Percorrer a lista de geojson e retornar apenas a do município passado como parâmetro

        $retorno = null;
        if(!empty($listaGeoJson)){
            $listaGeoJson = json_decode($listaGeoJson);

            foreach ($listaGeoJson->features as $dados) {
                if($dados->properties->id == trim($codigoIBGE)){
                    $retorno = $dados;
                    break;
                }
            }
        }
        return $retorno;
    }

    function getPrevisaoMunicipios($dadosWS){

       
        $retorno = null;
        $listaGeoJson = self:: getDadosMunicipio($dadosWS);

        if(!empty($listaGeoJson)){

            $conteudoPrevisao = null;
            $urlConsulta = self::getUrl('LISTA_PREVISOES',$dadosWS);

            $conteudoPrevisao = file_get_contents($urlConsulta);
            
            if(!empty($conteudoPrevisao)){
                $conteudoPrevisao = json_decode($conteudoPrevisao);
               
                $retorno = $conteudoPrevisao;

                
                foreach($conteudoPrevisao->previsao_municipios as $chave => $dados){
                    $codigoIBGE         = $conteudoPrevisao->previsao_municipios[$chave]->numero_ibge;
                    $codigoMunicipio    = $conteudoPrevisao->previsao_municipios[$chave]->codigo; 
                    $geoJson = self:: getMunicipioByLista($listaGeoJson, $codigoIBGE);
                    $retorno->previsao_municipios[$chave]->geoJson = $geoJson;

                    // if($codigoMunicipio == "184"){
                    //     // var_dump($dados->previsao );die;
                    //     var_dump(self::getPrevisaoByIdMunicipio($dadosWS, $codigoMunicipio));die;
                    // }

                    if(empty( $dados->previsao  ) || $dados->previsao == "null"){
                        $previsao = self::getPrevisaoByIdMunicipio($dadosWS, $codigoMunicipio);
                        if(is_null($previsao)){
                            $previsao = 'null';
                        }
                        $retorno->previsao_municipios[$chave]->previsao = $previsao;
                    }else{                        
                        $retorno->previsao_municipios[$chave]->previsao = $dados->previsao;
                    }
                    
                }

            }
        }

        return $retorno;

    }

    function getPrevisaoTeste(){
        $previsao = array(
            0 => array(
                0 => array(
                    date('d-m-Y')
                ),
                1 => array(
                    'titulo' => 'Temperatura Máxima',
                    'valor'  => mt_rand(25, 29) . "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Max_temperature.png'
                ),
                2 => array(
                    'titulo' => 'Temperatura Mínima',
                    'valor'  =>  mt_rand(20, 24) . "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Min_temperature.png'
                ),
                3 => array(
                    'titulo' => 'Umidade Relativa Máxima',
                    'valor'  =>  mt_rand(90, 99). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/RH_Max.png'
                ),
                4 => array(
                    'titulo' => 'Umidade Relativa Mínima',
                    'valor'  =>  mt_rand(70, 80). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/RH_Min.png'
                ),
                5 => array(
                    'titulo' => 'Ponto de Orvalho Máximo',
                    'valor'  =>  mt_rand(22, 25). "." . mt_rand(0, 9), 23.0,
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/TO_Max.png'
                ),
                6 => array(
                    'titulo' => 'Ponto de Orvalho Mínimo',
                    'valor'  =>  mt_rand(20, 21). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/TO_Min.png'
                ),
                7 => array(
                    'titulo' => 'Pressão Máxima',
                    'valor'  =>  mt_rand(1012, 1015). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Pressure_Max.png'
                ),
                8 => array(
                    'titulo' => 'Pressão Mínima',
                    'valor'  =>  mt_rand(1010, 1011). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Pressure_Min.png'
                ),
                9 => array(
                    'titulo' => 'Velocidade do Vento',
                    'valor'  => 'Moderada',
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Wind_speed.png'
                ),
                10 => array(
                    'titulo' => 'Variação da Direção do Vento',
                    'valor'  => 'Norte',
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Wind_Direction.png'
                ),
                11 => array(
                    'titulo' => 'Chuva do dia',
                    'valor'  => mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Chuva.png'
                ),
                'icone' => 'http://200.238.105.69/previsao_municipios/Config/Icones/Imagens/Cl_Sc.png'
            ),
        
            1 => array(
                0 => array(
                    date('d-m-Y',strtotime("+1 day"))
                ),
                1 => array(
                    'titulo' => 'Temperatura Máxima',
                    'valor'  => mt_rand(25, 29) . "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Max_temperature.png'
                ),
                2 => array(
                    'titulo' => 'Temperatura Mínima',
                    'valor'  =>  mt_rand(20, 24) . "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Min_temperature.png'
                ),
                3 => array(
                    'titulo' => 'Umidade Relativa Máxima',
                    'valor'  =>  mt_rand(90, 99). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/RH_Max.png'
                ),
                4 => array(
                    'titulo' => 'Umidade Relativa Mínima',
                    'valor'  =>  mt_rand(70, 80). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/RH_Min.png'
                ),
                5 => array(
                    'titulo' => 'Ponto de Orvalho Máximo',
                    'valor'  =>  mt_rand(22, 25). "." . mt_rand(0, 9), 23.0,
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/TO_Max.png'
                ),
                6 => array(
                    'titulo' => 'Ponto de Orvalho Mínimo',
                    'valor'  =>  mt_rand(20, 21). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/TO_Min.png'
                ),
                7 => array(
                    'titulo' => 'Pressão Máxima',
                    'valor'  =>  mt_rand(1012, 1015). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Pressure_Max.png'
                ),
                8 => array(
                    'titulo' => 'Pressão Mínima',
                    'valor'  =>  mt_rand(1010, 1011). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Pressure_Min.png'
                ),
                9 => array(
                    'titulo' => 'Velocidade do Vento',
                    'valor'  => 'Moderada',
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Wind_speed.png'
                ),
                10 => array(
                    'titulo' => 'Variação da Direção do Vento',
                    'valor'  => 'Norte',
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Wind_Direction.png'
                ),
                11 => array(
                    'titulo' => 'Chuva do dia',
                    'valor'  => mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Chuva.png'
                ),
                'icone' => 'http://200.238.105.69/previsao_municipios/Config/Icones/Imagens/Cl_Sc.png'
            ),
        
            2 => array(
                0 => array(
                    date('d-m-Y',strtotime("+2 day"))
                ),
                1 => array(
                    'titulo' => 'Temperatura Máxima',
                    'valor'  => mt_rand(25, 29) . "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Max_temperature.png'
                ),
                2 => array(
                    'titulo' => 'Temperatura Mínima',
                    'valor'  =>  mt_rand(20, 24) . "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Min_temperature.png'
                ),
                3 => array(
                    'titulo' => 'Umidade Relativa Máxima',
                    'valor'  =>  mt_rand(90, 99). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/RH_Max.png'
                ),
                4 => array(
                    'titulo' => 'Umidade Relativa Mínima',
                    'valor'  =>  mt_rand(70, 80). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/RH_Min.png'
                ),
                5 => array(
                    'titulo' => 'Ponto de Orvalho Máximo',
                    'valor'  =>  mt_rand(22, 25). "." . mt_rand(0, 9), 23.0,
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/TO_Max.png'
                ),
                6 => array(
                    'titulo' => 'Ponto de Orvalho Mínimo',
                    'valor'  =>  mt_rand(20, 21). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/TO_Min.png'
                ),
                7 => array(
                    'titulo' => 'Pressão Máxima',
                    'valor'  =>  mt_rand(1012, 1015). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Pressure_Max.png'
                ),
                8 => array(
                    'titulo' => 'Pressão Mínima',
                    'valor'  =>  mt_rand(1010, 1011). "." . mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Pressure_Min.png'
                ),
                9 => array(
                    'titulo' => 'Velocidade do Vento',
                    'valor'  => 'Moderada',
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Wind_speed.png'
                ),
                10 => array(
                    'titulo' => 'Variação da Direção do Vento',
                    'valor'  => 'Norte',
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Wind_Direction.png'
                ),
                11 => array(
                    'titulo' => 'Chuva do dia',
                    'valor'  => mt_rand(0, 9),
                    'icone'  => 'http://200.238.105.69/previsao_municipios/Config/Icones/Chuva.png'
                ),
                'icone' => 'http://200.238.105.69/previsao_municipios/Config/Icones/Imagens/Cl_Sc.png'
            )
        
        );
        
        return $previsao;
    }
}