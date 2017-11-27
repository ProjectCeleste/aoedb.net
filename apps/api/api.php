<?php
class api extends app
{
	function __construct(&$parent)
	{
		parent::__construct($parent);
        $this->load->app('items');
        $this->load->app('units');
    }
    
    public function c_index() {

    }
		
	public function c_item($id = null, $level = null)
	{	
        if ($level)
            $level += 3;
    
        $item = $this->items->m_item->load($id, $level)->info;
        $item = $this->simplifyItem($item);

        $this->json($item);
    }

    public function c_items()
	{	
        $page = $this->uri->query_param('page') ? $this->uri->query_param('page') : 1;
        $page_size = $this->uri->query_param('page_size') ? $this->uri->query_param('page_size') : 100;
        $type = $this->uri->query_param('type');
        $items = $this->items->m_item->GetPaginated($type, $page, $page_size);
        $result["page"] = $page;
        $result["total"] =  $this->items->m_item->GetCount($type);
        $result["pages"] = ceil($result["total"]/$page_size);
        $result["items"] = [];

        foreach($items as $item){
            $result["items"][] = $this->simplifyItem($item);
        }

        $this->json($result);
    }

	public function c_unit($id = null)
	{	
        if(!$id)
        {
            return $this->json([]);
        }
        $unit = $this->units->m_proto->load($id)->info;
        $unit = $this->simplifyUnit($unit);

        $this->json($unit);
    }

    public function c_units($id=null) {

        if ($id !== null){
            return $this->c_unit($id);
        }

        $page = $this->uri->query_param('page');
        $page_size = $this->uri->query_param('page_size') ? $this->uri->query_param('page_size') : 100;
        $civ = $this->uri->query_param('civ');
        $type = $this->uri->query_param('type');
        $units = $this->units->m_proto->GetPaginated($civ, $type, $page, $page_size);
        $result = [];
        
        $result["page"] = $page > 0 ? $page : 1;
        $result["total"] = $this->units->m_proto->get_total_count($civ, $type, $page_size);
        $result["pages"] = ceil($result["total"]/$page_size);
        
        foreach($units as $unit){
            $result["items"][] = $this->simplifyUnit($unit);
        }
       
       $this->json($result);
    }

    protected function simplifyUnit($proto){

        if(!isset($proto['DBID']))
        {
            return [];
        }

        unset($proto["id"]);
        $proto["UnitTypes"] = explode(",", $proto["UnitTypes"]);
        $proto["Flags"] = explode(",", $proto["Flags"]);
        return $proto;
    }

    protected function simplifyItem($item) {
        
        $item["display_name"] = $item["DisplayName"];
        $item["rollover_text"] = $item["RolloverText"];

        //addressing a misnomer - effectstrings is an object that has a useful toString method
        //that converts the effect data into a nice string
        $effects = $item["effectstrings"];

        foreach($effects as $effect)
        {
            $newEffect = $effect->info;
            $newEffect["description"] =  $effect->__toString();
            $newEffect["bonus"] = $newEffect["bonus"] == "true";
            $item["effects"][] = $newEffect;
        }

        $item["tradeable"] =  $item["tradeable"] == "1";
        $item["destroyable"] =  $item["destroyable"] == "1";
        $item["sellable"] =  $item["sellable"] == "1";

        $item["icon"] = "/images/Art/" . $item["icon"] . ".png";
        
        if(isset($item["level"])) {
            $item["level"] =  $item["level"] - 3;
        }
    
        $item["available_levels"] = explode("|", $item["levels"]);

        unset($item["tr_id"]);
        unset($item["displaynameid"]);
        unset($item["rollovertextid"]);
        unset($item["DisplayName"]);
        unset($item["RolloverText"]);

        unset($item["effectstrings"]);
        unset($item["levels"]);

        return $item;
    }

}

/**end of file*/