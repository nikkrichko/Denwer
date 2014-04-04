<?php
/**
*	@version	$Id: fontpreview.php 20 2013-04-02 05:19:28Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

//No direct access!
defined( 'JPATH_BASE' ) or die();

jimport('joomla.html.html');
jimport('joomla.form.formfield');
 /**
 * @since	OMG 1.0
 */
class JFormFieldFontPreview extends JFormField
{
	// Name of Element
	protected $type = 'FontPreview';
	
	// Function to create an element
	protected function getInput()
	{
		$fontPreview = '<div style="display: none;" class="font-preview rounded">font preview<span style="font-size: 30px;" class="span-font-preview"></span><a id="font-preview-close-btn" onclick="closePreview()" href="javascript:void(0)"></a></div>';
		
		// this run on php 5.3 but not in php 5.2 ??
		//if(isset($this->element['inline-style']) && $this->element['inline-style']->__toString() == 'true') {
		
		$node = $this->element;
		if(trim($node->getAttribute('inline-style')) == 'true'){
			$fontPreview .= '
			<style type="text/css">
				div.font-preview{
					background: none repeat 0 0 #FFF;
					border: 1px solid #CCC;
					font-size: 12px;
					min-height: 180px;
					height:auto !important; 
					height: 180px; 
					padding: 10px;
					position: fixed;
					right: 5%;
					text-align: center;
					top: 40%;
					width: 200px;
					
					-webkit-box-shadow: 0 0 3px 3px rgba(0, 0, 0, 0.2); /* Safari, Chrome */
					-moz-box-shadow: 0 0 3px 3px rgba(0, 0, 0, 0.2); /* Firefox */
					box-shadow: 0 0 3px 3px rgba(0, 0, 0, 0.2);
				}
				span.span-font-preview{
					float: left;
					width: 100%;
					text-align: center;
					
				}
				a#font-preview-close-btn{
					background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABGdJREFUeNpMVEtvHEUYrO7p2Zl9eM1uvI6d2HEWQSIfMEocCDlggxPlJxDJ4sCNH+AoESLgEygyB05wQoITIAWQQD6AgoQVfMBJrBChRIANRnEcP/DaG+97ph983WMQszszPT091dVV9TWbW30XK+vXUcqXeb2xcjbMjFxuxA+fZwqAMbAHZ4zaDP8/uMeQ9QcXavre1bzXP1ePt1TfgZcg7EvB04f+qPz0XkuuTB6UPyCTC2E8gLmfcbiGSXDOkra9UHutHp/bamfO9nhHP+vND08R1IZgjGdbcmdGqaXJ0WNZpFlIX8SOBTP7oMRQm9Dd/z1s66kCw46S7M6fy5NodOveIn9doNk4vde6feF4WaBTa2MNKTBFbEwC6HkerYATo2aCZNkRsO1PIYtucBwr+7i/fHNS185/LPZk7UqQkaISCcR1D2nRgXFC2KUqaG0gNUfK565PE3tGemjStB7UoKMsAs9HIdvgVV25wptqfcwqqWIFT0hEjENJRR/5CIICNDpQBNCWBjQE6dQgPB7SRBp+RGO9FtomQoqUqsvtMc60bhptJ+duRZIeJIENly5ifOA7FMJn0Uad+jooBScw3ncDw4VpAvX/W4EhRT0rA+nCbQf93RIMgWrdQU9uFCOlN9EbnsSL/dcIaBhF/yTODHyOXDCE48UpFDKnoHQErTQcgI2SPe3FgkkHasiAENXGffy+84GVDPngaUwMzOLloa9J3yGrLH7ZegfbjVs0NnAgdvlaGRcnwThzQIpm4QQsyNo2q2L+wRQ6agcjPW8RqycduNQx7mxfxq9/vw8hfAjPhZWACJCIMnrkFtXGS9vTukgNjzKnucaD6nUyZI8cQwKIXWzW5iFprDIBTUjjSblEP7g4ceYiaq/cRUxZU6I2juTO4Fz5GlLsAIVRUqUYhLwXE4OzGAgnCKhup4dS2smAJFXullSESfIfqRhPpJ/B+JFvkBUDxLyDhfWLWNy4RO9jZFK9GBv6AgV/FLGUJBWBOlLcASYRTmxOOrlAI97AZvMmyvnzuPXoDdzd+BCMU0Qoj88duoqd9iIivU3L4y4ykvSzHjDPmsq9jCt4myemXdHXZRVzf72G3/Knsbr7LVgoYJTAz1sz2JNL2G3cRls/ovJjCaBSBOroZXnGL/0Y2SUTOS9KkyY2SxxNU8VSZRaKewRmKMhUSb6P5d2vUJVriJlwpx+HxCGFxxIIRel73uX3v42Yas4ncf0GhEqDEwAnRh5C57pSVGIR6SQ5fOrjmqokJhvblEMRkbIRTNOL8qI4LUK/f6EUjH65Xbl3oe+gRMqLyOWEsdnfV22JCXJUeMLtidY8K5HgLcQ0YGMN6AlOfdKd6V8U2uioKyhOaTWA6ubDV/ygzrrTyQeMJxusDa12BKVz0m3k9FzpAJ1WptPlD33aneubVkbFzmWpO2uHiyderXcOf5RLj1yqRasvWGZ8P/QGyQYAV+/7dUsrKHcdvfHYvzuTDnrmo3jXbjH4R4ABAGAtM73sJL1WAAAAAElFTkSuQmCC") no-repeat scroll 0 0 transparent;
					color: #FFFFFF;
					font-size: 18px;
					height: 20px;
					position: absolute;
					right: -1px;
					top: -1px;
					width: 20px;
				}
			</style>
			';
		}
		return $fontPreview;
	}
	
	protected function getLabel()
	{
		return '';
	}
}						