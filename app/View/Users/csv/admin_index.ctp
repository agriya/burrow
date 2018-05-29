<?php
$i = 0;
do {
    $user->paginate = array(
        'conditions' => $conditions,
        'offset' => $i,
          'contain' => array(
                       'Ip' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'Timezone' => array(
                            'fields' => array(
                                'Timezone.name',
                            )
                        ) ,
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host',
                        )
                    ) ,
                  ) ,
        'fields' => array(
            'User.username',
            'User.email',
            'User.available_wallet_amount',
            'User.property_count',
            'User.travel_total_booked_count',
            'User.travel_total_site_revenue',
            'User.host_total_site_revenue',
            'User.user_login_count',
        ),
		'order' => array(
			'User.id' => 'desc'
		) ,
        'recursive' => 0
    );
    if(!empty($q)){
        $user->paginate['search'] = $q;
    }
   $Users = $user->paginate();
      if (!empty($Users)) {
        $data = array();
        foreach($Users as $User) {
			$data[]['User'] = array(
				'Username' => $User['User']['username'],
				'Email' => $User['User']['email'],
				'Available Wallet Amount' => $User['User']['available_wallet_amount'],
				'Property Count' => $User['User']['property_count'],
				'Total Bookings as Traveler' => $User['User']['travel_total_booked_count'],
				'Site Revenue' => $User['User']['travel_total_site_revenue'] + $User['User']['host_total_site_revenue'],
				'Login count' => $User['User']['user_login_count'],
			);
        }
        if (!$i) {
            $this->Csv->addGrid($data);
        } else {
            $this->Csv->addGrid($data, false);
        }
    }
    $i+= 20;
}
while (!empty($Users));
echo $this->Csv->render(true);
?>