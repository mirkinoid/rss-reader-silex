<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Model\NewsMapper;
use App\Model\NewsEntity;

class Front
{
    public function getIndex(Application $app, Request $request)
    {
        $mapper = new NewsMapper($app['db']);
        $mapper->getNews();
        die();

        return include '../templates/index.tpl.php';
    }
    
    public function getLogin(Request $request)
    {
        return new Response('<form action="/login" method="POST">
            <input name="name">
            <input name="pass">
            <input type="submit">
        </form>');
    }

    public function postLogin(Application $app, Request $request)
    {
        $login = $request->request->get('name');
        $pass = $request->request->get('pass');

        $session = $request->getSession();
        if ($login == 'test' && $pass == '123') {
            $session->set('logged', true);

            return 'LOGGED';
            // return new RedirectResponse('/cabinet');
        }

        return $app->redirect('/login');
    }

    public function getLogout($request, $response)
    {
        $session = $request->getSession();
        $session->invalidate();

        return new RedirectResponse('/');
    }
}
