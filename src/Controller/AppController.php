<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent(
            'Auth',
            [
                'authenticate' => [
                    'Form' => [
                        'fields' => ['username' => 'email', 'password' => 'password']
                    ]

                ],
                'authorize' => ['Controller'],
                'unauthorizedRedirect' => $this->referer(),


            ]
        );
        $this->set('user', $this->Auth->user());
        $this->Auth->allow([
            'registro',
            'registrar',
            'cadastrosenha',            
            'login',
            'logout',           
            'forget',
            'sucesso',
            'users',
            'editoria',
            'galerias',
            'pesquisa',
            'certificado',
            'rematricula',
            'pesquisarematricula',

        ]);

        if (isset($_SESSION['Auth']['User']['id'])) {

            $this->loadModel('Users');
            $usuario = $this->Users->get($_SESSION['Auth']['User']['id'], [
                'contain' => [],
            ]);
            $this->set(compact('usuario'));

            define('ID', $_SESSION['Auth']['User']['id']);
            define('PERFIL', $_SESSION['Auth']['User']['profile_id']);
            define('USUARIO', $_SESSION['Auth']['User']['title']);
            define('EMAIL', $_SESSION['Auth']['User']['email']);
        }

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');


    }

   


    ///// MES
    public function trad($mes)
    {
        switch ($mes) {
            case "01":
                return "Jan";
                break;
            case "02":
                return "Fev";
                break;
            case "03":
                return "Mar";
                break;
            case "04":
                return "Abr";
                break;
            case "05":
                return "Mai";
                break;
            case "06":
                return "Jun";
                break;
            case "07":
                return "Jul";
                break;
            case "08":
                return "Ago";
                break;
            case "09":
                return "Set";
                break;
            case "10":
                return "Out";
                break;
            case "11":
                return "Nov";
                break;
            case "12":
                return "Dez";
                break;
        }
    }
    ///// ORGANIZA DATA
    public function organizadt($dat)
    {
        $dt = explode(" ", $dat);
        $data = explode("-", $dt[0]);
        $dtd = $data[2] . "/" . $data[1] . "/" . $data[0];
        $hr = explode(":", $dt[1]);
        $hora = $hr[0] . "h" . $hr[1];
        return $dtd;
    }

    public function tlinks($name)
    {
        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "ñ", " ", "'", "´", "`", "/", "\\", "~", "^", "¨", ".", ",", "\"", ":", "?", "!", "*");

        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "n", "_", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");

        return strtolower(str_replace($array1, $array2, $name));
    }


    public function isAuthorized($user = null)
    {
        // Usuário com profile_id = 3 tem permissões restritas
        if ($user['profile_id'] == 3) {
            // Permitir acesso ao controlador "Links" e ações específicas
            if (
                $this->request->getParam('controller') === 'Links' &&
                in_array($this->request->getParam('action'), ['viewdigitador', 'view'])
            ) {
                return true;
            }

            // Permitir acesso ao controlador "Users" para editar e excluir
            if (
                $this->request->getParam('controller') === 'Users' &&
                in_array($this->request->getParam('action'), ['editdigitador', 'delete'])
            ) {
                // Aqui você pode adicionar lógica adicional, se necessário,
                // como verificar se o usuário está editando/deletando seu próprio registro
                return true;
            }

            // Bloquear acesso a qualquer outro controlador ou ação
            return false;
        }

        // Para outros perfis, permitir todas as ações
        return true;
    }


}
