export default class NovaApiParser {
    // class methods
    parse(api_response, posted_states)
    {
        let temp_array = [];
        let i, j;
        for (i = 0; i < api_response.data.resources.length; i++)
        {
            let resource_object = {};
            for (j = 0; j < api_response.data.resources[i].fields.length; j++)
            {
                let property_name = api_response.data.resources[i].fields[j].attribute;
                let property_value = api_response.data.resources[i].fields[j].value
                resource_object[property_name] = property_value
                if (api_response.data.resources[i].fields[j].attribute === 'favorite_status')
                for (let state of posted_states){
                    if (state.id === api_response.data.resources[i].fields[j].value){
                    resource_object['favorite_status_string'] = state.name
                    break;
                    }
                }
            }
            temp_array.push(resource_object)
        }
        
        return temp_array
    }
}