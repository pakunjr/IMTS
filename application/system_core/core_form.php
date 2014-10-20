<?php

class Form {

    private $form_id;
    private $auto_label;
    private $auto_line_break;

    public function __construct ($o=array())
    {
        $this->form_id = isset($o['id']) ? $o['id'] : '';

        $cond = isset($o['auto_label']);
        $this->auto_label = $cond ? $o['auto_label'] : false;

        $cond = isset($o['auto_line_break']);
        $this->auto_line_break = $cond ? $o['auto_line_break'] : false;
    }



    public function __destruct ()
    {

    }



    // Open a form tag
    public function openForm ($o=array())
    {
        return '<form autocomplete="off"'.$this->parseAttributes($o).'>';
    }



    // Close a form tag
    public function closeForm ()
    {
        return '</form>';
    }



    // Open a fieldset tag
    public function openFieldset ($o=array())
    {
        $output = '<fieldset'.$this->parseAttributes($o).'>';

        $cond = isset($o['legend']);
        $output .= $cond ? '<legend>'.$o['legend'].'</legend>' : '';
        return $output;
    }



    // Close a fieldset tag
    public function closeFieldset ()
    {
        return '</fieldset>';
    }



    /** BEGIN FORM ELEMENTS GENERATOR FUNCTIONS **/



    public function hidden ($o=array())
    {
        $output = '<input type="hidden"'.$this->parseAttributes($o).' />';
        return $output;
    }



    public function text ($o=array())
    {
        $output = $this->renderLabel($o).'<input type="text"'.$this->parseAttributes($o).' />'.$this->autoLineBreak($o);
        return $output;
    }



    public function textarea ($o=array())
    {
        $e = array('value');
        $value = isset($o['value']) ? $o['value'] : '';
        $output = $this->renderLabel($o).'<textarea'.$this->parseAttributes($o, $e).'>'.$value.'</textarea>'.$this->autoLineBreak($o);
        return $output;
    }



    public function password ($o=array())
    {
        $output = $this->renderLabel($o).'<input type="password"'.$this->parseAttributes($o).' />'.$this->autoLineBreak($o);
        return $output;
    }



    public function select ($o=array())
    {
        $e = array(
                'select_options',
                'default_option',
                'placeholder'
            );

        $select_options = '';
        $so = 'select_options';

        if (isset($o[$so]) && is_array($o[$so])) {
            foreach ($o[$so] as $n => $v) {
                $cond = isset($o['default_option'])
                    && $o['default_option'] === $v;
                $isDefault = $cond ? ' selected="selected"' : '';

                $select_options .= '<option'.$isDefault.' value="'.$v.'">'.$n.'</option>';
            }
        } else {
            $select_options .= '<option value="option_1">Option 1</option><option value="option_2">Option 2</option>';
        }

        $output = $this->renderLabel($o).'<select'.$this->parseAttributes($o, $e).'>'.$select_options.'</select>'.$this->autoLineBreak($o);

        return $output;
    }



    public function radio ($o=array())
    {
        $e = array('placeholder', 'checked');

        $cond = isset($o['checked']) && $o['checked'];
        $checkAttr = $cond ? ' checked="checked"' : '';

        $output = $this->renderLabel($o).'<input type="radio"'.$checkAttr.$this->parseAttributes($o, $e).' />'.$this->autoLineBreak($o);
        return $output;
    }



    public function checkbox ($o=array())
    {
        $e = array('placeholder', 'checked');

        $cond = isset($o['checked']) && $o['checked'];
        $checkAttr = $cond ? ' checked="checked"' : '';

        $output = $this->renderLabel($o).'<input type="checkbox"'.$checkAttr.$this->parseAttributes($o, $e).' />'.$this->autoLineBreak($o);
        return $output;
    }



    public function file ($o=array())
    {
        $output = $this->renderLabel($o).'<input type="file"'.$this->parseAttributes($o).' />'.$this->autoLineBreak($o);
        return $output;
    }



    public function button ($o=array())
    {
        $e = array('placeholder');
        $output = '<input type="button"'.$this->parseAttributes($o, $e).' />'.$this->autoLineBreak($o);
        return $output;
    }



    public function reset ($o=array())
    {
        $e = array('placeholder');
        $output = '<input type="reset"'.$this->parseAttributes($o, $e).' />'.$this->autoLineBreak($o);
        return $output;
    }



    public function submit ($o=array())
    {
        $e = array('placeholder');
        $output = '<input type="submit"'.$this->parseAttributes($o, $e).' />'.$this->autoLineBreak($o);
        return $output;
    }



    /** END FORM ELEMENTS GENERATOR FUNCTIONS **/



    /**
     * Parse the attributes that will be inserted
     * in each generated elements in each functions
     */
    private function parseAttributes ($o=array(), $e=array())
    {
        $tmp_attr = '';
        array_push(
            $e,
            'label',
            'legend',
            'line_break',
            'auto_label',
            'auto_line_break'
        );

        // Process automated placeholder attribute
        $cond = !isset($o['placeholder'])
                && !in_array('placeholder', $e);

        if ($cond) {
            if (isset($o['label'])) {
                $o['placeholder'] = $o['label'];
            } else if (isset($o['name'])) {
                $o['placeholder'] = $o['name'];
            } else if (isset($o['id'])) {
                $o['placeholder'] = $o['id'];
            }
        }

        // Process automated name attribute
        $cond = !isset($o['name'])
            && isset($o['id'])
            && !in_array('name', $e);

        if ($cond) {
            $o['name'] = $o['id'];
        }

        // Process automated title attribute
        $cond = !isset($o['title'])
            && !in_array('title', $e);

        if ($cond) {
            if (isset($o['label'])) {
                $o['title'] = $o['label'];
            } else if (isset($o['placeholder'])) {
                $o['title'] = $o['placeholder'];
            } else if (isset($o['name'])) {
                $o['title'] = $o['name'];
            } else if (isset($o['id'])) {
                $o['title'] = $o['id'];
            }
        }

        // Process remaining attributes
        foreach ($o as $n => $v) {
            if (!in_array($n, $e)) {
                $tmp_attr .= ' '.$n.'="'.$v.'"';
            }
        }

        return $tmp_attr;
    }



    // Render the label of each elements or functions
    private function renderLabel ($o=array())
    {
        $cond = isset($o['auto_label'])
            && !$o['auto_label'];

        if ($cond) {
            return false;
        } else if (!$this->auto_label) {
            return false;
        }

        $id = isset($o['id']) ? $o['id'] : '';

        if (isset($o['label'])) {
            $label = $o['label'];
        } else if (isset($o['name'])) {
            $label = $o['name'];
        } else if (isset($o['id'])) {
            $label = $o['id'];
        } else {
            $label = '';
        }

        $htmlOutput = '<label for="'.$id.'">'.$label.'</label>';
        return PHP_EOL.$htmlOutput;
    }



    // Render auto line break for each elements
    // and the whole form
    private function autoLineBreak ($o=array())
    {
        $lineBreak = '<br />'.PHP_EOL;
        if (!empty($o['auto_line_break'])) {
            return $o['auto_line_break'] ? $lineBreak : '';
        } else {
            return $this->auto_line_break ? $lineBreak : '';
        }
    }

}
