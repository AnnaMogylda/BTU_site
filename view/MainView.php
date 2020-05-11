<?php

require_once('View.php');

class MainView extends View {

    /*Отображение контента главной страницы*/
    public function fetch() {
        if (isset($_SESSION['message_sent'])) {
            $this->design->assign('message_sent', $_SESSION['message_sent']);
            unset($_SESSION['message_sent']);
        }

        $feedback = new stdClass;
        /*Принимаем заявку с формы обратной связи*/
        if ($this->request->method('post') && $this->request->post('feedback')) {
            $feedback->name         = trim($this->request->post('name') . ' ' . $this->request->post('lastname'));
            $feedback->from_place   = $this->request->post('place');
            $feedback->to_place     = $this->request->post('destination');
            $feedback->to_date      = $this->request->post('date');
            $feedback->passengers   = $this->request->post('passengers');
            $feedback->phone        = $this->request->post('phone');
            $feedback->email        = $this->request->post('email');
            // $captcha_code           = $this->request->post('captcha_code');
            
            $feedback_name = explode(' ', $feedback->name);
            $this->design->assign('name',       $feedback_name[0]);
            $this->design->assign('lastname',   $feedback_name[1]);
            $this->design->assign('place',      $feedback->from_place);
            $this->design->assign('destination',$feedback->to_place);
            $this->design->assign('date',       $feedback->to_date);
            $this->design->assign('passengers', $feedback->passengers);
            $this->design->assign('phone',      $feedback->phone);
            $this->design->assign('email',      $feedback->email);

            /*Валидация данных клиента*/
            if (!$this->validate->is_name($feedback->name, true)) {
                $this->design->assign('error', 'empty_name');
            } elseif (!$this->validate->is_comment($feedback->from_place)) {
                $this->design->assign('error', 'empty_from');
            } elseif (!$this->validate->is_comment($feedback->to_place)) {
                $this->design->assign('error', 'empty_text');
            } elseif (!$this->validate->is_comment($feedback->to_date)) {
                $this->design->assign('error', 'empty_name');
            } elseif(!$this->validate->is_comment($feedback->passengers)) {
                $this->design->assign('error', 'empty_passengers');
            } elseif(!$this->validate->is_phone($feedback->phone, true)) {
                $this->design->assign('error', 'empty_phone');
            } elseif(!$this->validate->is_email($feedback->email, true)) {
                $this->design->assign('error', 'empty_email');
            // } elseif ($this->settings->captcha_feedback && !$this->validate->verify_captcha('captcha_feedback', $captcha_code)) {
            //     $this->design->assign('error', 'captcha');
            } else {
                $_SESSION['message_sent'] = 1;
                $this->design->assign('message_sent', true);
                
                $feedback->ip = $_SERVER['REMOTE_ADDR'];
                $feedback->lang_id = $_SESSION['lang_id'];
                $feedback_id = $this->feedbacks->add_feedback($feedback);
                
                // Отправляем email
                $this->notify->email_feedback_admin($feedback_id);

                header('Location: ' . $this->config->root_url);
                exit();
            }
        }

        if ($this->page) {
            $this->design->assign('meta_title', $this->page->meta_title);
            $this->design->assign('meta_keywords', $this->page->meta_keywords);
            $this->design->assign('meta_description', $this->page->meta_description);
        }
        return $this->design->fetch('main.tpl');
    }
    
}
