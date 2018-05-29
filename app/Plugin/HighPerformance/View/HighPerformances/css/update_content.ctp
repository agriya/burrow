<?php
$uids = $from = '';
$display_none_arr = $display_block_arr = $none_height_style = $pids = $rids = array(
    ''
);
if (!empty($_GET['pids'])) {
    $pids = $_GET['pids'];
    $pids = explode(',', $pids);
}
if (!empty($_GET['rids'])) {
    $rids = $_GET['rids'];
    $rids = explode(',', $rids);
}
if (!empty($_GET['uids'])) {
    $uids = $_GET['uids'];
}
if (!empty($_GET['from'])) {
    $from = $_GET['from'];
}
// Property Favorite starts here //
if (isPluginEnabled('PropertyFavorites')) {
    if (!empty($_GET['pids'])) {
        $fid = array(
            ''
        );
        if ($this->Auth->user('id')) {
            foreach($followingPropertyIds as $followingProperties) {
                $fid[] = $followingProperties['PropertyFavorite']['property_id'];
            }
        }
        for ($i = 0; $i < count($pids); $i++) {
            if (!$this->Auth->user('id')) {
                $display_none_arr[] = 'alpuf-sm-' . $pids[$i];
                $display_none_arr[] = 'alpf-' . $pids[$i];
                $display_none_arr[] = 'alpuf-' . $pids[$i];
                $display_block_arr[] = 'blpuf-' . $pids[$i];
                $display_block_arr[] = 'blpf-' . $pids[$i];
            } else {
                $display_none_arr[] = 'blpuf-' . $pids[$i];
                $display_none_arr[] = 'alpuf-sm-' . $pids[$i];
                if (in_array($pids[$i], (array)$ownPropertyIds)) {
                    $display_none_arr[] = 'alpf-' . $pids[$i];
                    $display_none_arr[] = 'alpuf-' . $pids[$i];
                    $display_none_arr[] = 'blpf-' . $pids[$i];
                    $display_block_arr[] = 'aloed-' . $pids[$i];
                } else {
                    if (in_array($pids[$i], (array)$fid)) {
                        $display_block_arr[] = 'alpuf-' . $pids[$i];
                        $display_none_arr[] = 'alpf-' . $pids[$i];
                    } else {
                        $display_block_arr[] = 'alpf-' . $pids[$i];
                        $display_none_arr[] = 'alpuf-' . $pids[$i];
                    }
                }
            }
        }
    }
}
// Property Favorite ends here //
// Request Favorite starts here //
if (isPluginEnabled('RequestFavorites')) {
    if (!empty($_GET['rids'])) {
        $fid = $ruid = array(
            ''
        );
        if ($this->Auth->user('id')) {
            foreach($followingRequestIds as $followingRequests) {
                $fid[] = $followingRequests['RequestFavorite']['request_id'];
            }
        }
        for ($i = 0; $i < count($rids); $i++) {
            if (!$this->Auth->user('id')) {
                $display_none_arr[] = 'alprf-' . $rids[$i];
                $display_none_arr[] = 'alpruf-' . $rids[$i];
                $display_block_arr[] = 'blprf-' . $rids[$i];
                $display_none_arr[] = 'aloed-' . $rids[$i];
                $display_block_arr[] = 'al-mao-' . $rids[$i];
            } else {
                $display_none_arr[] = 'blpruf-' . $rids[$i];
                $display_none_arr[] = 'alpruf-sm-' . $rids[$i];
                
                if (in_array($rids[$i], (array)$ownRequestIds)) {
                    $display_block_arr[] = 'aloed-' . $rids[$i];
                    $display_none_arr[] = 'alprf-' . $rids[$i];
                    $display_none_arr[] = 'alpruf-' . $rids[$i];
					$display_none_arr[] = 'al-mao-' . $rids[$i];
                } else {
                    $display_none_arr[] = 'aloed-' . $rids[$i];
					 $display_block_arr[] = 'al-mao-' . $rids[$i];
                    if (in_array($rids[$i], (array)$fid)) {
                        $display_block_arr[] = 'alpruf-' . $rids[$i];
                        $display_none_arr[] = 'alprf-' . $rids[$i];
                    } else {
                        $display_block_arr[] = 'alprf-' . $rids[$i];
                        $display_none_arr[] = 'alpruf-' . $rids[$i];
                    }
                }
            }
        }
    }
}
// Request Favorite ends here //
// Request Flag start here //
if (!empty($_GET['rids'])) {
    for ($i = 0; $i < count($rids); $i++) {
        if (!$this->Auth->user('id')) {
            $display_none_arr[] = 'alvfp-' . $rids[$i];
            $display_block_arr[] = 'blvfp-' . $rids[$i];
        } else {
            $display_none_arr[] = 'blvfp-' . $rids[$i];
            if (!in_array($rids[$i], (array)$ownRequestIds)) {
                $display_block_arr[] = 'alvfp-' . $rids[$i];
            } else {
                $display_none_arr[] = 'alvfp-' . $rids[$i];
            }
        }
    }
}
// Request Flag end here //
// Property book it starts here //
if (!empty($_GET['pids'])) {
    if ($this->Auth->user('id')) {
        for ($i = 0; $i < count($pids); $i++) {
            if (in_array($pids[$i], (array)$ownPropertyIds)) {
                $display_none_arr[] = 'al-pbi-' . $pids[$i];
                $display_block_arr[] = 'al-php-' . $pids[$i];
            } else {
                $display_block_arr[] = 'al-pbi-' . $pids[$i];
                $display_none_arr[] = 'al-php-' . $pids[$i];
            }
        }
    } else {
        for ($i = 0; $i < count($pids); $i++) {
            $display_block_arr[] = 'al-pbi-' . $pids[$i];
            $display_none_arr[] = 'al-php-' . $pids[$i];
        }
    }
}
if (!empty($_GET['pids'])) {
    if ($this->Auth->user('id')) {
        if (in_array($pids[0], (array)$ownPropertyIds)) {
            $display_none_arr[] = 'alpb';
        } else {
            $display_block_arr[] = 'alpb';
        }
    } else {
        $display_block_arr[] = 'alpb';
    }
}
// Property book it end here //
// Property Flag start here //
if (!empty($_GET['pids'])) {
    for ($i = 0; $i < count($pids); $i++) {
        if (!$this->Auth->user('id')) {
            $display_none_arr[] = 'alvfp-' . $pids[$i];
            $display_block_arr[] = 'blvfp-' . $pids[$i];
        } else {
            $display_none_arr[] = 'blvfp-' . $pids[$i];
            if (!in_array($pids[$i], (array)$ownPropertyIds)) {
                $display_block_arr[] = 'alvfp-' . $pids[$i];
            } else {
                $display_none_arr[] = 'alvfp-' . $pids[$i];
            }
        }
    }
}
// Property Flag book it end here //
// User follow starts here //
if (!empty($_GET['uids'])) {
    if ($this->Auth->user('id')) {
        $uid = array(
            ''
        );
        foreach($followinguserIds as $followinguser) {
            $uid[] = $followinguser['UserFollower']['followed_user_id'];
        }
    }
    if (!$this->Auth->user('id')) {
        $display_block_arr[] = 'blu-f-' . $uids;
        $display_none_arr[] = 'alu-f-' . $uids;
        $display_none_arr[] = 'alou-f-' . $uids;
        $display_none_arr[] = 'alu-uf-' . $uids;
    } else {
        $display_none_arr[] = 'blu-f-' . $uids;
        if ($this->Auth->user('id') == $uids) {
            $display_none_arr[] = 'alu-f-' . $uids;
            $display_block_arr[] = 'alou-f-' . $uids;
            $display_none_arr[] = 'alu-uf-' . $uids;
        } else {
            $display_none_arr[] = 'alou-f-' . $uids;
            if (!in_array($uids, $uid)) {
                $display_block_arr[] = 'alu-f-' . $uids;
                $display_none_arr[] = 'alu-uf-' . $uids;
            } else {
                $display_none_arr[] = 'alu-f-' . $uids;
                $display_block_arr[] = 'alu-uf-' . $uids;
            }
        }
    }
}
// User Follow ends here //
// Admin user and contest control panel start here //
if ($this->Auth->sessionValid() && $this->Auth->user('role_id') == ConstUserTypes::Admin) {
    $display_block_arr[] = 'alab';
} else {
    $display_none_arr[] = 'alab';
}
// Facebook Relation starts here //
if (!empty($_GET['pids'])) {
    $fid = array(
        ''
    );
    if ($this->Auth->user('id')) {
        foreach($followingPropertyIds as $followingProperties) {
            $fid[] = $followingProperties['PropertyFavorite']['property_id'];
        }
    }
    for ($i = 0; $i < count($pids); $i++) {
        if (!$this->Auth->user('is_facebook_friends_fetched')) {
            $display_block_arr[] = 'blfbr-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-e-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-d-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-nl-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-na-' . $pids[$i];
        } elseif (!$this->Auth->user('is_show_facebook_friends')) {
            $display_none_arr[] = 'blfbr-' . $pids[$i];
            $display_block_arr[] = 'alfbr-fb-e-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-d-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-nl-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-na-' . $pids[$i];
        } elseif (empty($property['User']['is_facebook_friends_fetched'])) {
            $display_none_arr[] = 'blfbr-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-e-' . $pids[$i];
            $display_block_arr[] = 'alfbr-fb-d-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-nl-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-na-' . $pids[$i];
        } elseif (!empty($network_level[$property['Property']['user_id']])) {
            $display_none_arr[] = 'blfbr-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-e-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-d-' . $pids[$i];
            $display_block_arr[] = 'alfbr-fb-nl-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-na-' . $pids[$i];
        } else {
            $display_none_arr[] = 'blfbr-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-e-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-d-' . $pids[$i];
            $display_none_arr[] = 'alfbr-fb-nl-' . $pids[$i];
            $display_block_arr[] = 'alfbr-fb-na-' . $pids[$i];
        }
    }
}
// Facebook Relation ends here //
$none_style = implode(', .', $display_none_arr);
$none_style_height = implode(', .', $display_none_arr);
$none_style = substr($none_style, 1); //to remove 1st ',' from the array
$none_style_height = substr($none_style_height, 1); //to remove 1st ',' from the array
$none_style = $none_style . ' { display: none; }';
$none_height_style = $none_style_height . ' { height: 0px; }';
$block_style = implode(', .', $display_block_arr);
$block_style = substr($block_style, 1); //to remove 1st ',' from the array
$block_style = $block_style . ' { display: block; }';
echo preg_replace('/(\>)\s+(<?)/', '$1$2', $block_style);
echo preg_replace('/(\>)\s+(<?)/', '$1$2', $none_style);
echo preg_replace('/(\>)\s+(<?)/', '$1$2', $none_height_style);
?>