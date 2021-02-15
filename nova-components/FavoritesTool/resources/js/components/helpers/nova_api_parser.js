export default class NovaApiParser {
    // class methods
    parse(api_response)
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
                }
                temp_array.push(resource_object)
            }
            
            return temp_array
    }
    parse_using_foreach(api_response)
    {
        let temp_array = []
        let final_array = []
        temp_array = api_response.data.resources
        temp_array.forEach(function(favorite, index) {
            console.log(favorite)
            
        })
        
    }
  }


