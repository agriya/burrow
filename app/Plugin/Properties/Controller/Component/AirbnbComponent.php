<?php
/**
 * Burrow
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    Burrow
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class AirbnbComponent extends Component
{
	var $mapping = array(
		'amenities' => array(
			'11' => '1', // Smoking Allowed
			'12' => '2', // Pets Allowed
			'1' => '3', // TV
			'2' => '4', // Cable TV
			'3' => '5', // Internet
			'4' => '6', // Wireless Internet
			'5' => '7', // Air Conditioning
			'30' => '8', // Heating
			'21' => '9', // Elevator in Building
			'6' => '10', // Handicap Accessible
			'7' => '11', // Pool
			'8' => '12', // Kitchen
			'9' => '13', // Parking Included
			'13' => '14', // Washer / Dryer
			'14' => '15', // Doorman
			'15' => '16', // Gym
			'25' => '17', // Hot Tub
			'27' => '18', // Indoor Fireplace
			'28' => '19', // Buzzer/Wireless Intercom
			'16' => '20', // Breakfast
			'31' => '21', // Family/Kid Friendly
			'32' => '22', // Suitable for Events
		) ,
		'property_types' => array(
			'1' => '1', // Apartment
			'2' => '2', // House
			'3' => '3', // Bed & Breakfast
			'4' => '4', // Cabin
			'11' => '5', // Villa
			'5' => '6', // Castle
			'9' => '7', // Dorm
			'6' => '8', // Treehouse
			'8' => '9', // Boat
			'7' => '10', // Automobile
			'12' => '11', // lgloo
			'10' => '12', // Lighthouse
		) ,
		'room_types' => array(
			'Private room' => '1', // Private room
			'Shared room' => '2', // Shared room
			'Entire home/apt' => '3', // Entire room
		) ,
		'bed_types' => array(
			'Airbed' => '1', // Airbed
			'Futon' => '2', // Futon
			'Pull-out Sofa' => '3', // Pull-out sofa
			'Couch' => '4', // Couch
			'Real Bed' => '5', // Real bed
		) ,
		'size' => array(
			'true' => '1', // Square Feet
			'false' => '2', // Square Meters
		) ,
		'cancellation_policy' => array(
			'3' => '1', // Flexible
			'4' => '2', // Moderate
			'5' => '3', // Strict
		)
	);
	public function import($data, $step, $importedProperties)
	{
		set_time_limit(0);
		App::import('Model', 'Properties.Property');
        $this->Property = new Property();
		$login = $this->_curlGetURL('https://www.airbnb.com/login');
		$post_variable = 'email=' . urlencode($data['Property']['airbnb_email']) . '&password=' . $data['Property']['airbnb_password'];
		$this->_curlGetURL('https://www.airbnb.com/authenticate', $post_variable, true);
		if ($step == 1) {
			$rooms = $this->_curlGetURL('http://www.airbnb.com/rooms');
			preg_match_all('/<h3>[^\/]*<a href="\/rooms\/(\d+)">(.*)<\/a>[^\/]*<\/h3>/', $rooms, $matches);
			$properties = array();
			if (!empty($matches[1])) {
				$i = 0;
				foreach($matches[1] as $match) {
					$properties[$i]['Property']['id'] = $matches[1][$i];
					$properties[$i]['Property']['title'] = $matches[2][$i];
					$i++;
				}
			}
			return $properties;
		} elseif ($step == 2) {
			$return = array();
			unset($data['Property']['airbnb_email']);
			unset($data['Property']['airbnb_password']);
			unset($data['Property']['step2']);
			foreach($data['Property'] as $id => $is_checked) {
				if (!empty($is_checked['id'])) {
					if (!in_array($id, array_values($importedProperties))) {
						$_data = array();
						// @todo active, inactive
						$room_details = $this->_curlGetURL('https://www.airbnb.com/rooms/' . $id . '/edit');
						preg_match('/listingAttrs = {"listing":{\s*.*/', $room_details, $details);
						$details = str_replace('listingAttrs = ', "", $details[0]);
						preg_match('/"property_type_id":(\d+),/msU', $details, $property_type);
						if (!empty($property_type[1])) {
							$_data['Property']['property_type_id'] = $this->mapping['property_types'][$property_type[1]];
						}
						preg_match('/"room_type":"(.*)",/msU', $details, $room_type);
						if (!empty($room_type[1])) {
							$_data['Property']['room_type_id'] = $this->mapping['room_types'][$room_type[1]];
						}
						preg_match('/"name":"(.*)",/msU', $details, $title);
						if (!empty($title[1])) {
							$_data['Property']['title'] = $title[1];
						}
						preg_match('/"description":"(.*)",/msU', $details, $description);
						if (!empty($description[1])) {
							$_data['Property']['description'] = $description[1];
						}
						preg_match_all('/"amenities_ids":\[(.*)\],/msU', $details, $amenities);
						if (!empty($amenities[1])) {
							$amenities = explode(",", $amenities[1][0]);
							$_data['Property']['is_pets'] = 0;
							if(in_array(17, $amenities)) {
								$_data['Property']['is_pets'] = 1;
								$key = array_search(17, $amenities);
								unset($amenities[$key]);
							}
							$new_amenities_arr = array();
							foreach($amenities as $amenity) {
								if(!empty($amenity)) {
									$new_amenities_arr[] = $this->mapping['amenities'][$amenity];
								}
							}
							if(count($new_amenities_arr)>0) {
								$_data['Amenity']['Amenity'] = $new_amenities_arr;
							}
						}
						preg_match('/"person_capacity":(\d+),/msU', $details, $accommodates);
						if (!empty($accommodates[1])) {
							$_data['Property']['accommodates'] = $accommodates[1];
						}
						preg_match('/"bedrooms":(\d+),/msU', $details, $bed_rooms);
						if (!empty($bed_rooms[1])) {
							$_data['Property']['bed_rooms'] = $bed_rooms[1];
						}
						preg_match('/"beds":(\d+),/msU', $details, $beds);
						if (!empty($beds[1])) {
							$_data['Property']['beds'] = $beds[1];
						}
						preg_match('/"bed_type":"(.*)",/msU', $details, $bed_type);
						if (!empty($bed_type[1])) {
							$_data['Property']['bed_type_id'] = $this->mapping['bed_types'][$bed_type[1]];
						}
						preg_match('/"bathrooms":(.*),/msU', $details, $bath_rooms);
						if (!empty($bath_rooms[1])) {
							$_data['Property']['bath_rooms'] = round($bath_rooms[1]);
						}
						preg_match('/"square_feet":(.*),/msU', $details, $size);
						if (!empty($size[1]) && $size[1]!='null') {
							$_data['Property']['size'] = $size[1];
							$_data['Property']['measurement'] = 1;
						}
						preg_match('/<input id="square_feet_or_square_meters".*\/>.*<select.*id="square_feet_in_feet".*>.*value="([a-zA-Z]+)" selected="selected">\s*.*<\/select>/msU', $room_details, $measurement);
						if (!empty($measurement[1])) {
							$_data['Property']['measurement'] = $this->mapping['size'][$measurement[1]];
						}
						preg_match('/"house_rules":"(.*)",/msU', $details, $house_rules);
						if (!empty($house_rules[1])) {
							$_data['Property']['house_rules'] = $house_rules[1];
						}
						preg_match('/"house_manual":"(.*)",/msU', $details, $house_manual);
						if (!empty($house_manual[1])) {
							$_data['Property']['house_manual'] = $house_manual[1];
						}
						preg_match('/"full_address":"(.*)",/msU', $details, $address);
						if (!empty($address[1])) {
							$_data['Property']['address'] = $address[1];
						}
						preg_match('/"lat":(.*),/msU', $details, $lat);
						preg_match('/"lng":(.*),/msU', $details, $lng);
						if (!empty($lat[1]) && !empty($lng[1])) {
							$_data['Property']['latitude'] = $lat[1];
							$_data['Property']['longitude'] = $lng[1];
							App::uses('HttpSocket', 'Network/Http');
							$HttpSocket = new HttpSocket();
							$map_details = $HttpSocket->get('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $_data['Property']['latitude'] . ',' . $_data['Property']['longitude'] . '&sensor=true');
							if (!empty($map_details)) {
								$maps = json_decode($map_details);
								if ($maps->status == 'OK') {
									if (!empty($maps->results[0]->address_components)) {
										foreach($maps->results[0]->address_components as $tmp_map_arr) {
											if ($tmp_map_arr->types[0] == 'country') {
												$_data['Property']['country_id'] = $this->Property->Country->findCountryId($tmp_map_arr->short_name);
											} elseif ($tmp_map_arr->types[0] == 'administrative_area_level_1') {
												$_data['Property']['state_id'] = $this->Property->State->findOrSaveAndGetId($tmp_map_arr->long_name);
											} elseif ($tmp_map_arr->types[0] == 'administrative_area_level_2') {
												$_data['Property']['city_id'] = $this->Property->City->findOrSaveAndGetId($tmp_map_arr->long_name);
											}
										}
									}
								}
							}
						}
						$price_details = $this->_curlGetURL('https://www.airbnb.com/calendar/single/' . $id);
						preg_match('/<input.*id="hosting_price_native".*value="(.*)" \/>/', $price_details, $price_per_night);
						if (!empty($price_per_night[1])) {
							$_data['Property']['price_per_night'] = $price_per_night[1];
						} else {
							preg_match('/"listing_price_native":(.*),/msU', $details, $price_per_night);
							if (!empty($price_per_night[1])) {
								$_data['Property']['price_per_night'] = $price_per_night[1];
							}
						}
						preg_match('/<input.*id="hosting_weekly_price_native".*value="(.*)" \/>/', $price_details, $price_per_week);
						if (!empty($price_per_week[1])) {
							$_data['Property']['price_per_week'] = $price_per_week[1];
						} else {
							preg_match('/"listing_weekly_price_native":(.*),/msU', $details, $price_per_week);
							if (!empty($price_per_week[1])) {
								$_data['Property']['price_per_week'] = $price_per_week[1];
							}
						}
						preg_match('/<input.*id="hosting_monthly_price_native".*value="(.*)" \/>/', $price_details, $price_per_month);
						if (!empty($price_per_month[1])) {
							$_data['Property']['price_per_month'] = $price_per_month[1];
						} else {
							preg_match('/"listing_monthly_price_native":(.*),/msU', $details, $price_per_month);
							if (!empty($price_per_month[1])) {
								$_data['Property']['price_per_month'] = $price_per_month[1];
							}
						}
						preg_match('/"listing_price_for_extra_person_native":(.*),/msU', $details, $additional_guest_price);
						if (isset($additional_guest_price[1])) {
							$_data['Property']['additional_guest_price'] = $additional_guest_price[1];
						}
						preg_match('/"guests_included":(.*),/msU', $details, $additional_guest);
						if (!empty($additional_guest[1])) {
							$_data['Property']['additional_guest'] = $additional_guest[1];
						}
						preg_match('/"listing_security_deposit_native":(.*),/msU', $details, $security_deposit);
						if (!empty($security_deposit[1])) {
							$_data['Property']['security_deposit'] = $security_deposit[1];
						}
						preg_match('/"cancel_policy":(\d+),/msU', $details, $cancellation_policy);
						if (!empty($cancellation_policy[1])) {
							$_data['Property']['cancellation_policy_id'] = $this->mapping['cancellation_policy'][$cancellation_policy[1]];
						}
						$_data['Property']['minimum_nights'] = 1;
						preg_match('/"min_nights_input_value":(\d+),/msU', $details, $minimum_nights);
						if (!empty($minimum_nights[1])) {
							$_data['Property']['minimum_nights'] = $minimum_nights[1];
						}
						$_data['Property']['maximum_nights'] = 0;
						preg_match('/"max_nights_input_value":(\d+),/msU', $details, $maximum_nights);
						if (!empty($maximum_nights[1])) {
							if ($maximum_nights[1] >= 365) {
								$maximum_nights[1] = 0;
							}
							$_data['Property']['maximum_nights'] = $maximum_nights[1];
						}
						$_data['Property']['checkin'] = '06:00:00';
						preg_match('/"check_in_time":(\d+),/msU', $details, $checkin);
						if (isset($checkin[1])) {
							if ($checkin[1] != '') {
								$_data['Property']['checkin'] = '0' . $checkin[1] . ':00:00';
							}
						}
						$_data['Property']['checkout'] = '09:00:00';
						preg_match('/"check_out_time":(\d+),/msU', $details, $checkout);
						if (isset($checkout[1])) {
							if ($checkout[1] != '') {
								$_data['Property']['checkout'] = '0' . $checkout[1] . ':00:00';
							}
						}
						$_data['Property']['is_imported_from_airbnb'] = 1;
						$_data['Property']['airbnb_property_id'] = $id;
						$_data['Property']['user_id'] = $_SESSION['Auth']['User']['id'];
						$_data['Property']['ip_id'] = $this->Property->toSaveIp();
						$_data['Property']['is_paid'] = (!Configure::read('property.listing_fee')) ? 1 : 0;
						$_data['Property']['is_approved'] = (Configure::read('property.is_auto_approve')) ? 1 : 0;
						$this->Property->create();
						if ($this->Property->save($_data)) {
							$calendar_details = $this->_curlGetURL('http://www.airbnb.com/calendar/single/' . $id);
							if (preg_match('/<div class="ical_link">\s+<a href="(.*)">.*<\/a>\s+<\/div>/', $calendar_details, $ical_link)) {
								if (!empty($ical_link[1])) {
									$calendar_details = $this->_curlGetURL($ical_link[1]);
									$fp = fopen(CACHE . $id . '.ics', 'x+');
									fwrite($fp, $calendar_details);
									fclose($fp);
									require_once(APP . 'Vendor' . DS . 'iCalReader.inc.php');
									$ical = new ical(CACHE . $id . '.ics');
									$reservation_arr = $ical->get_event_array();
									foreach($reservation_arr as $reservation) {
										$_custom_data = array();
										$_custom_data['CustomPricePerNight']['property_id'] = $this->Property->getLastInsertID();
										$_custom_data['CustomPricePerNight']['start_date'] = date('Y-m-d', $ical->ical_date_to_unix_timestamp($reservation['DTSTART']));
										$_custom_data['CustomPricePerNight']['end_date'] = date('Y-m-d', $ical->ical_date_to_unix_timestamp($reservation['DTEND']));
										$_custom_data['CustomPricePerNight']['price'] = $_data['Property']['price_per_night'];
										if ($reservation['SUMMARY'] == 'Not available') {
											$_custom_data['CustomPricePerNight']['is_available'] = 0;
										} elseif (preg_match('/(\d+) [a-zA-Z ]/', $reservation['SUMMARY'], $tmp_calendar_details)) {
											$_custom_data['CustomPricePerNight']['is_available'] = 0;
										} elseif (preg_match('/(\d+)$/', $reservation['SUMMARY'], $tmp_calendar_details)) {
											$_custom_data['CustomPricePerNight']['is_available'] = 1;
											$_custom_data['CustomPricePerNight']['price'] = $tmp_calendar_details[1];
										}
										$this->Property->CustomPricePerNight->create();
										$this->Property->CustomPricePerNight->save($_custom_data);
									}
									@unlink(CACHE . $id . '.ics');
								}
							}
							$photo_details = $this->_curlGetURL('https://www.airbnb.com/pictures?type=Hosting&id=' . $id);
							if (!empty($photo_details)) {
								$photos = json_decode($photo_details);
								$i = 1;
								foreach($photos as $photo) {
									$_attachment_data = array();
									$_attachment_data['Attachment']['filename']['type'] = 'image/jpeg';
									$_attachment_data['Attachment']['filename']['name'] = 'image_' . $i . '.jpg';
									$_attachment_data['Attachment']['filename']['tmp_name'] = $photo->large_url;
									$_attachment_data['Attachment']['filename']['size'] = 0;
									$_attachment_data['Attachment']['filename']['error'] = 0;
									$this->Property->Attachment->Behaviors->attach('ImageUpload', Configure::read('property.file'));
									$this->Property->Attachment->isCopyUpload(true);
									$this->Property->Attachment->set($_attachment_data);
									$this->Property->Attachment->create();
									$_attachment_data['Attachment']['filename'] = $_attachment_data['Attachment']['filename'];
									$_attachment_data['Attachment']['user_id'] = $_SESSION['Auth']['User']['id'];
									$_attachment_data['Attachment']['class'] = 'Property';
									$_attachment_data['Attachment']['description'] = $photo->caption;
									$_attachment_data['Attachment']['foreign_id'] = $this->Property->getLastInsertID();
									$this->Property->Attachment->data = $_attachment_data['Attachment'];
									$this->Property->Attachment->save($_attachment_data);
									$this->Property->Attachment->Behaviors->detach('ImageUpload');
									$i++;
								}
							}
							$return['success'] = 1;
						} else {
							$return['ids'][] = $id;
							$return['error'] = 1;
						}
					} else {
						$return['ids'][] = $id;
						$return['error'] = 1;
					}
				}
			}
			return $return;
		}
	}
	function _curlGetURL($url, $data_arr = '' , $is_post = false)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		if ($is_post) {
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_arr);
		}
		curl_setopt($ch, CURLOPT_COOKIEFILE, APP . 'tmp' . DS . 'curl_cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEJAR, APP . 'tmp' . DS . 'curl_cookie.txt');
		$content = curl_exec($ch);
		if (!curl_errno($ch)) {
			curl_close($ch);
		} else {
			$content = false;
		}
		return $content;
	}
}
?>