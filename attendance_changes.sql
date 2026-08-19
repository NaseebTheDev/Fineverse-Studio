-- Add new setting for check-in restriction during work hours
INSERT INTO settings(setting_key, setting_value) 
VALUES ('check_in_during_work_hours_only', '0')
ON DUPLICATE KEY UPDATE setting_value = setting_value;
