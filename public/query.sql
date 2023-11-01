
/*only Below Two Value Only Allowed 0, 1*/
CREATE TYPE server_or_data AS ENUM ('0', '1');
ALTER TABLE opcua_temp ADD COLUMN is_node server_or_data;