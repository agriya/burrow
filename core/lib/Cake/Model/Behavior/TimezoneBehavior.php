<?php
class TimezoneBehavior extends ModelBehavior
{
	function beforeFind(Model $model, &$query)
	{
		if (!empty($query['conditions']) && is_array($query['conditions'])) {
			foreach($query['conditions'] as $key => $value) {
				if (!is_array($value)) {
					if (preg_match('/_date/', $key)) {
						$query['conditions'][$key] = _formatDate('Y-m-d H:i:s', $value, true);
					}
				}
			}
		}
		return $query;
	}
	function afterFind(Model $model, &$results)
    {
		if (is_array($results)) {
			foreach ($results as &$result) {
				$this->_updateTimezone($model, $result);
			}
		}
		return $results;
	}
	function _updateTimezone(Model $model, &$result)
	{
		if (!empty($result[$model->alias])) {
			$data = &$result[$model->alias];
		} else {
			$data = &$result;
		}
		if (!empty($data)) {
			foreach($data as $key => $value) {
				if ($key == 'modified' || $key == 'created' || preg_match('/_date/', $key) || preg_match('/_time$/', $key)) {
					if ($value != '0000-00-00 00:00:00' && $value != '0000-00-00') {
						if (!is_array($value)) {
							$hour_var = explode(':', $value);
							if (!empty($hour_var[1])) {
								$data[$key] = _formatDate('Y-m-d H:i:s', strtotime($value));
							} else {
								$data[$key] = _formatDate('Y-m-d', strtotime($value));
							}
						}
					}
				}
			}
		}
		if (isset($this->belongsTo)) {
			foreach ($this->belongsTo as $name => $relation) {
				if (isset($result[$name])) {
					$this->_updateTimezone($model->$name, $result[$name]);
				}
			}
		}
		if (isset($this->hasOne)) {
			foreach ($this->hasOne as $name => $relation) {
				if (isset($result[$name])) {
					$this->_updateTimezone($model->$name, $result[$name]);
				}
			}
		}
		if (isset($this->hasMany)) {
			foreach ($this->hasMany as $name => $relation) {
				if (isset($result[$name])) {
					foreach ($result[$name] as &$record) {
						$this->_updateTimezone($model->$name, $result[$name]);
					}
				}
			}
		}
		if (isset($this->hasAndBelongsToMany)) {
			foreach ($this->hasAndBelongsToMany as $name => $relation) {
				if (isset($result[$name])) {
					foreach ($result[$name] as &$record) {
						$this->_updateTimezone($model->$name, $result[$name]);
					}
				}
			}
		}
	}
}
?>