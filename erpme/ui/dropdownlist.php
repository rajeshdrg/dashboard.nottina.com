<?php

class DropDownList
{
	public $name;
	public $size;
	public $SqlDataReader;
	public $SqlCommand;
	public $Value;
	public $Text;
	public $SelectValue;
	public $itens;
	public $Required;
	public $ValidateMessage;
	public $color;
	public $SelectColor;
	public $ShowLabel;
	public $label;
	public $multiple;
	public $width;
	public $disabled;
	public $br;
	public $class;




	public function __construct($nome)
	{
		$this->name = $nome;
		$this->size = "10";
		$this->SqlCommand = NULL;
		$this->Value = 0;
		$this->SelectValue = "";
		$this->Required = false;
		$this->ValidateMessage = "O campo " . $this->name . " é obrigatório.";
		$this->color = NULL;
		$this->SelectColor = "white";
		$this->ShowLabel = false;
		$this->label = NULL;
		$this->multiple = false;
		$this->width = "300px";
		$this->disabled = "";
		$this->br = false;


	}

	public function ShowMe()
	{
		$lclass = "";

		if (!empty($this->LabelClass))
			$lclass = "class='$this->LabelClass'";

		if ($this->label != NULL)
			print "<label for='$this->name'>$this->label</label>";

		$o = "";

		if ($this->itens != null) {
			foreach ($this->itens as $key => $value) {
				$o .= "<option value=$key";

				if ($key == $this->SelectValue) {
					$o .= ' selected=true ';
				}

				$o .= ">$value</option>";
			}
		}




		if ($this->SqlDataReader != null) {

			$SqlDataReader = $this->SqlDataReader;

			$Result = $SqlDataReader->Result;

			for ($i = 0; $i < $this->SqlDataReader->Rows; $i++) {

				$value = pg_fetch_result($Result, $i, $this->Value);
				$text = pg_fetch_result($Result, $i, $this->Text);
				if ($this->color) {
					$color = pg_fetch_result($Result, $i, $this->color);
				}

				$o .= '<option value = ' . $value . '';
				if ($value == $this->SelectValue) {
					$o .= ' selected=true ';
				}

				/*	        	if($this->color) {
									$o .= " style='background:$color;' ";
									if($value ==  $this->SelectValue)
										$this->SelectColor = $color;
								}
				*/
				$o .= '>' . $text . "</option>";
			}
		}
		if ($this->multiple == true)
			print "<select $this->disabled name=$this->name" . "[] id=$this->name style='background:$this->SelectColor;width:$this->width;' class='$this->class' multiple ";
		else
			print "<select $this->disabled  name=$this->name id=$this->name class='$this->class'  ";
		//	    	print "<select $this->disabled  name=$this->name id=$this->name style='background:$this->SelectColor;width:$this->width;' ";
		print ' size=' . $this->size . '';
		/*
				if($this->color) {
					print " onChange='this.style.background=this.options[this.selectedIndex].style.background;' ";  
				}
		 * 
		 */
		print ">";

		print $o;

		print "</select>";
		if ($this->Required == true) {
			print "<font color=red>*</font>";
			print "<script language=\"javascript\">\n";
			print "ValidateFunctions.push(function () { \n";
			print 'var x=document.forms["aspnetForm"]["' . $this->name . '"].selectedIndex;' . "\n";
			print " if (x<=0)\n";
			print "  {\n";
			print "  return \"$this->ValidateMessage\";\n";
			print "} \n";
			print "else return null;\n";
			print "});\n";
			print "</script>\n";




		}
		if ($this->br)
			print "<div style='clear:both;'></div>\n";
	}
	public function __invoke()
	{
		$this->ShowMe();

	}
	public function bind()
	{
		if ($this->SqlCommand == null)
			return;

		$SqlCommand = $this->SqlCommand;
		$this->SqlDataReader = $SqlCommand->ExecuteReader();
	}
	public function Set($value)
	{
		$this->SelectValue = $value;
	}
}
;
?>