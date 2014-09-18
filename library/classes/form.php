<?php

class form {

    private $form_id;
    private $auto_label;
    private $auto_line_break;

    public function __construct ($o=array()) {
        $this->form_id = isset($o['id']) ? $o['id'] : '';
        $this->auto_label = isset($o['auto_label'])
            ? $o['auto_label'] : false;
        $this->auto_line_break = isset($o['auto_line_break'])
            ? $o['auto_line_break'] : false;
    }



    public function __destruct () {

    }



    // Open a form tag
    public function openForm ($o=array()) {
        return '<form autocomplete="off"'.$this->parseAttributes($o).'>';
    }



    // Close a form tag
    public function closeForm () {
        return '</form>';
    }



    // Open a fieldset tag
    public function openFieldset ($o=array()) {
        $output = '<fieldset'.$this->parseAttributes($o).'>';
        $output .= isset($o['legend'])
            ? '<legend>'.$o['legend'].'</legend>' : '';
        return $output;
    }



    // Close a fieldset tag
    public function closeFieldset () {
        return '</fieldset>';
    }



    /** BEGIN FORM ELEMENTS GENERATOR FUNCTIONS **/



    public function hidden ($o=array()) {
        $output = '<input type="hidden"'.$this->parseAttributes($o).' />';
        return $output;
    }



    public function text ($o=array()) {
        $output = $this->renderLabel($o)
                .'<input type="text"'.$this->parseAttributes($o).' />'
                .$this->autoLineBreak($o);
        return $output;
    }



    public function textarea ($o=array()) {
        $e = array('value');
        $value = isset($o['value']) ? $o['value'] : '';
        $output = $this->renderLabel($o)
                .'<textarea'.$this->parseAttributes($o, $e).'>'.$value.'</textarea>'
                .$this->autoLineBreak($o);
        return $output;
    }



    public function password ($o=array()) {
        $output = $this->renderLabel($o)
                .'<input type="password"'.$this->parseAttributes($o).' />'
                .$this->autoLineBreak($o);
        return $output;
    }



    public function select ($o=array()) {
        $e = array('select_options'
                ,'default_option'
                ,'placeholder');

        $select_options = '';
        if ( isset($o['select_options']) && is_array($o['select_options']) ) {
            foreach ( $o['select_options'] as $n => $v ) {
                $isDefault = isset($o['default_option'])
                            && $o['default_option'] === $v
                            ? ' selected="selected"'
                            : '';
                $select_options .= '<option'.$isDefault.' value="'.$v.'">'
                                .$n
                                .'</option>';
            }
        } else {
            $select_options .= '<option value="option_1">Option 1</option>'
                            .'<option value="option_2">Option 2</option>';
        }

        $output = $this->renderLabel($o)
                .'<select'.$this->parseAttributes($o, $e).'>'
                .$select_options
                .'</select>'
                .$this->autoLineBreak($o);
        return $output;
    }



    public function radio ($o=array()) {
        $e = array('placeholder', 'checked');

        $checkAttr = isset($o['checked']) && $o['checked']
            ? ' checked="checked"'
            : '';

        $output = $this->renderLabel($o)
                .'<input type="radio"'.$checkAttr.$this->parseAttributes($o, $e).' />'
                .$this->autoLineBreak($o);
        return $output;
    }



    public function checkbox ($o=array()) {
        $e = array('placeholder', 'checked');

        $checkAttr = isset($o['checked']) && $o['checked']
            ? ' checked="checked"'
            : '';

        $output = $this->renderLabel($o)
            .'<input type="checkbox"'.$checkAttr.$this->parseAttributes($o, $e).' />'
            .$this->autoLineBreak($o);
        return $output;
    }



    public function file ($o=array()) {
        $output = $this->renderLabel($o)
            .'<input type="file"'.$this->parseAttributes($o).' />'
            .$this->autoLineBreak($o);
        return $output;
    }



    public function button ($o=array()) {
        $e = array('placeholder');
        $output = '<input type="button"'.$this->parseAttributes($o, $e).' />'
            .$this->autoLineBreak($o);
        return $output;
    }



    public function reset ($o=array()) {
        $e = array('placeholder');
        $output = '<input type="reset"'.$this->parseAttributes($o, $e).' />'
            .$this->autoLineBreak($o);
        return $output;
    }



    public function submit ($o=array()) {
        $e = array('placeholder');
        $output = '<input type="submit"'.$this->parseAttributes($o, $e).' />'
            .$this->autoLineBreak($o);
        return $output;
    }



    /** END FORM ELEMENTS GENERATOR FUNCTIONS **/



    /**
     * Parse the attributes that will be inserted
     * in each generated elements in each functions
     */
    private function parseAttributes ($o=array(), $e=array()) {
        $tmp_attr = '';
        array_push(
            $e
            ,'label'
            ,'legend'
            ,'line_break'
            ,'auto_label'
            ,'auto_line_break'
        );

        // Process automated placeholder attribute
        if ( !isset($o['placeholder']) && !in_array('placeholder', $e) ) {
            if ( isset($o['name']) )
                $o['placeholder'] = $o['name'];
            else if ( isset($o['id']) )
                $o['placeholder'] = $o['id'];
        }

        // Process automated name attribute
        if ( !isset($o['name']) && isset($o['id']) && !in_array('name', $e) ) {
            $o['name'] = $o['id'];
        }

        // Process automated title attribute
        if ( !isset($o['title']) && !in_array('title', $e) ) {
            if ( isset($o['label']) )
                $o['title'] = $o['label'];
            else if ( isset($o['placeholder']) )
                $o['title'] = $o['placeholder'];
            else if ( isset($o['name']) )
                $o['title'] = $o['name'];
            else if ( isset($o['id']) )
                $o['title'] = $o['id'];
        }

        // Process remaining attributes
        foreach ( $o as $n => $v ) {
            if ( !in_array($n, $e) )
                $tmp_attr .= ' '.$n.'="'.$v.'"';
        }
        return $tmp_attr;
    }



    // Render the label of each elements or functions
    private function renderLabel ($o=array()) {
        if ( isset($o['auto_label']) && !$o['auto_label'] ) return false;
        else if ( !$this->auto_label ) return false;

        $id = isset($o['id']) ? $o['id'] : '';
        if ( isset($o['label']) )
            $label = $o['label'];
        else if ( isset($o['name']) )
            $label = $o['name'];
        else if ( isset($o['id']) )
            $label = $o['id'];
        else
            $label = '';
        $output = '<label for="'.$id.'">'
                .$label
                .'</label>';
        return PHP_EOL.$output;
    }



    /**
     * Render auto_line_break and the
     * auto_line_break settings of each
     * form functions
     */
    private function autoLineBreak ($o=array()) {
        if ( isset($o['auto_line_break']) ) {
            if ( $o['auto_line_break'] )
                return '<br />'.PHP_EOL;
            else
                return '';
        } else if ( $this->auto_line_break )
            return '<br />'.PHP_EOL;
        else
            return '';
    }



    public function generateSelectOptions ($array, $label, $value) {
        $so = array();
        foreach ( $array as $a ) {
            $so[$a[$label]] = $a[$value];
        }
        return $so;
    }



    public function generate ($options=array()) {
        if ( isset($options['type']) ) {
            switch ( $options['type'] ) {
                case 'select_options':
                    if ( isset($options['datas'])
                        && isset($options['label'])
                        && isset($options['value']) ) {
                        $so = array();
                        foreach ( $options['datas'] as $a ) {
                            $so[$a[$options['label']]] = $a[$options['value']];
                        }
                        return $so;
                    }
                    break;

                default:
            }
        }
    }

}
