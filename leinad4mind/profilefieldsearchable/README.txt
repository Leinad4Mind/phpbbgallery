OPEN [phpBB root]/adm/style/acp_profile.html

FIND
	<th>{L_FIELD_TYPE}</th>
ADD AFTER
	<!-- EVENT acp_profile_custom_fields_list_head_append -->
	
FIND
	<td>{fields.FIELD_TYPE}</td>
ADD AFTER
	<!-- EVENT acp_profile_custom_fields_list_field_append -->
