<xrds:XRDS
    xmlns:xrds="xri://$xrds"
    xmlns:openid="http://openid.net/xmlns/1.0"
    xmlns="xri://$xrd*($v*2.0)">
    <XRD>
        <Service priority="0">
            <Type>http://specs.openid.net/auth/2.0/return_to</Type>
            <URI><?php echo Router::url(array('controller' => 'users', 'action' => 'login'), true); ?></URI>
        </Service>
    </XRD>
</xrds:XRDS>