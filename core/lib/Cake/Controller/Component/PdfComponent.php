<?php
/**
 * PDF component. Uses html2fpdf library (http://html2fpdf.sourceforge.net/)
 *
 * @author      rajesh_04ag02 // 2008-10-21
 * Note: Original version from http://web.archive.org/web/20060204101737/http://wiki.cakephp.org/tutorials:creating_pdfs_easy
 *      But, heavily modified it to work with Router::parseExetensions() and make it automatic
 * Usage: 1. Enable Router::parseExtensions() for 'pdf'
 *        2. Add this component to any controller (if global, add it to AppController)
 *        3. Layout search path (automagic) order:
 *                      layouts/pdf/default.ctp
 *                      layouts/ajax.ctp
 *                      layouts/default.ctp
 *        4. View search path order:
 *                      controller/pdf/action.ctp
 *                      controller/action.ctp
 *    So, even if specialized view or layout is not added, it will work for all.
 * @bug    It doesn't take the correct CSS file when the HTML file contains CSS
 *          Check with debug > 0, below
 */

define('RELATIVE_PATH', VENDORS . 'html2fpdf' . DS);
require_once (VENDORS . DS . 'html2fpdf' . DS . 'html2fpdf.php');

class PdfComponent extends Component
{
    var $helpers = array(
        'Html'
    );
    function beforeRender(Controller $controller)
    {
        if ($controller->RequestHandler->prefers('pdf')) {
            // if layout is not found, fallback to HTML
            if (!file_exists(LAYOUTS . $controller->layoutPath . DS . $controller->layout . $controller->ext)) {
                $controller->layout = 'default';
                // if ajax layout found, better use that as automatic
                if (file_exists(LAYOUTS . $controller->layoutPath . DS . 'ajax' . $controller->ext)) {
                    $controller->layout = 'ajax';
                }
                $controller->layoutPath = null;
            }
            // if pdf special view not found, fallback to HTML
            if (!file_exists(VIEWS . $controller->params['controller'] . DS . 'pdf' . DS . $controller->params['action'] . $controller->ext)) {
                $controller->viewPath = $controller->params['controller'];
            }
        }
    }
    function shutdown(Controller $controller)
    {
        if ($controller->RequestHandler->prefers('pdf')) {
            $buffer = $controller->output;
            $controller->output = null;
            $buffer = utf8_decode($buffer); //I use utf8, need decoding to ISO-8859-1
            Configure::write('debug', 0);
            $pdf = new HTML2FPDF();
            $pdf->AddPage();
            $pdf->WriteHTML($buffer);
            $pdf->Output($controller->params['controller'] . '-' . $controller->params['action'] . '.pdf', 'I'); // I -Inline, D - Download, F - save file in hard disc (webroot)
        }
    }
}
?>