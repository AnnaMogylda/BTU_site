<?php

class StylesAdmin extends Home {

    /*Файл стилей шаблона*/
    public function fetch() {
        $current_theme = $this->settings->theme;
        if ($this->settings->admin_theme) {
            $current_theme = $this->settings->admin_theme;
        }

        $styles_dir = 'design/'.$current_theme.'/css/';
        $styles = array();
        // Чтаем все css-файлы
        if($handle = opendir($styles_dir)) {
            while(false !== ($file = readdir($handle))) {
                if(is_file($styles_dir.$file) && $file[0] != '.'  && pathinfo($file, PATHINFO_EXTENSION) == 'css') {
                    $styles[] = $file;
                }
            }
            closedir($handle);
        }
        asort($styles);
        
        // Текущий шаблон
        $style_file = $this->request->get('file');
        
        if(!empty($style_file) && pathinfo($style_file, PATHINFO_EXTENSION) != 'css') {
            exit();
        }
        
        // Если не указан - вспоминаем его из сессии
        if(empty($style_file) && isset($_SESSION['last_edited_style'])) {
            $style_file = $_SESSION['last_edited_style'];
        }
        // Иначе берем первый файл из списка
        elseif(empty($style_file)) {
            $style_file = reset($styles);
        }
        
        // Передаем имя шаблона в дизайн
        $this->design->assign('style_file', $style_file);
        
        // Если можем прочитать файл - передаем содержимое в дизайн
        if(is_readable($styles_dir.$style_file)) {
            $style_content = file_get_contents($styles_dir.$style_file);
            $this->design->assign('style_content', $style_content);
        }
        
        // Если нет прав на запись - передаем в дизайн предупреждение
        if(!empty($style_file) && !is_writable($styles_dir.$style_file) && !is_file($styles_dir.'../locked')) {
            $this->design->assign('message_error', 'permissions');
        } elseif(is_file($styles_dir.'../locked')) {
            $this->design->assign('message_error', 'theme_locked');
        } else {
            // Запоминаем в сессии имя редактируемого шаблона
            $_SESSION['last_edited_style'] = $style_file;
        }
        
        $this->design->assign('theme', $current_theme);
        $this->design->assign('styles', $styles);
        return $this->design->fetch('styles.tpl');
    }
    
}
