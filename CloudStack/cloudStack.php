<?php
/*
 * CloudStack Wrapper for PHP
 * Version 1.0
 * Created by Steven Lopez (Twitter: @augrunt | Email: steven@lopez.id.au)
 * NO SUPPORT, GUARANTEES OR WARRANTY OFFERED WITH THIS CODE. USE AT OWN RISK.
 */


class cloudStack
{
    protected $_secretKey = NULL;
    protected $_apiKey = NULL;
    protected $_targetApi = NULL;
    private $_curlEnabled = NULL;
    public $responseType = 'json';
	public $return_signed_only = false;
    
    public function __construct($targetApi, $apiKey, $secretKey)
    {
        $this->_apiKey    = $apiKey;
        $this->_secretKey = $secretKey;
        $this->_targetApi = $targetApi;
        
        if ($this->_checkCurl() == false) {
            $this->_curlEnabled = 0;
        } else {
            $this->_curlEnabled = 1;
        }
    }
    
    /******** Start Custom Methods ********/
    public function execute_command($command, $array = null)
    {
        if (empty($array)) {
            $array = array();
        }
        $static_array  = array(
            'command' => $command,
            'response' => $this->responseType
        );
        $command_array = array_merge($array, $static_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    /******** Start Template Related Methods *********/
    public function listTemplates($filter = 'executable')
    {
        $command_array = array(
            'command' => 'listTemplates',
            'templateFilter' => $filter,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function createTemplate($displaytext, $name, $ostypeid, $bits = null, $details = null, $isfeatured = null, $ispublic = null, $passwordenabled = null, $requireshvm = null, $snapshotid = null, $templatetag = null, $url = null, $virtualmachineid = null, $volumeid = null)
    {
        /**
        Creates a template of a virtual machine. A template created from this command is automatically designated as a private template visible to the account that created it.
        Either the snapshotid or the volumeid must be passed - if you pass the volumeid, the Virtual Machine must be in a STOPPED state.
        **/
        $command_array = array(
            'command' => 'createTemplate',
            'displaytext' => $displaytext,
            'name' => $name,
            'ostypeid' => $ostypeid,
            'bits' => $bits,
            'details' => $details,
            'isfeatured' => $isfeatured,
            'ispublic' => $ispublic,
            'passwordenabled' => $passwordenabled,
            'requireshvm' => $requireshvm,
            'snapshotid' => $snapshotid,
            'templatetag' => $templatetag,
            'url' => $url,
            'virtualmachineid' => $virtualmachineid,
            'volumeid' => $volumeid,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    /******** End Template Related Methods *********/
    /******** Start Async job Related Methods *********/
    public function listAsyncJobs()
    {
        $command_array = array(
            'command' => 'listAsyncJobs',
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function queryAsyncJobResult($jobid)
    {
        $command_array = array(
            'command' => 'queryAsyncJobResult',
            'jobid' => $jobid,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    /******** End Async job Related Methods *********/
    /******** Start Virtual Machine Related Methods *********/
    public function listVirtualMachines($account = null, $domainId = null, $forVirtualNetwork = null, $groupId = null, $hostId = null, $hypervisor = null, $id = null, $isRecursive = null, $keyword = null, $name = null, $networkId = null, $page = null, $pageSize = null, $podId = null, $state = null, $storageId = null, $zoneId = null)
    {
        $command_array = array(
            'command' => 'listVirtualMachines',
            'account' => $account,
            'domainid' => $domainId,
            'forvirtualnetwork' => $forVirtualNetwork,
            'groupid' => $groupId,
            'hostid' => $hostId,
            'hypervisor' => $hypervisor,
            'id' => $id,
            'isrecursive' => $isRecursive,
            'keyword' => $keyword,
            'name' => $name,
            'networkid' => $networkId,
            'page' => $page,
            'pagesize' => $pageSize,
            'podid' => $podId,
            'state' => $state,
            'storageid' => $storageId,
            'zoneid' => $zoneId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function startVirtualMachine($id)
    {
        $command_array = array(
            'command' => 'startVirtualMachine',
            'id' => $id,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function stopVirtualMachine($id)
    {
        $command_array = array(
            'command' => 'stopVirtualMachine',
            'id' => $id,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function rebootVirtualMachine($id)
    {
        $command_array = array(
            'command' => 'rebootVirtualMachine',
            'id' => $id,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function destroyVirtualMachine($id)
    {
        $command_array = array(
            'command' => 'destroyVirtualMachine',
            'id' => $id,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    /******** End Virtual Machine Related Methods *********/
    /******** Start Disk Related Methods *********/
    public function listVolumes($vm_id = null)
    {
        $command_array = array(
            'command' => 'listVolumes',
            'response' => $this->responseType
        );
        if ($vm_id != null) {
            $command_array['virtualmachineid'] = $vm_id;
        }
        
        $command = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function attachVolume($id, $virtualMachineId, $deviceId = null)
    {
        $command_array = array(
            'command' => 'attachVolume',
            'id' => $id,
            'virtualmachineid' => $virtualMachineId,
            'deviceid' => $deviceId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function detachVolume($id, $virtualMachineId, $deviceId = null)
    {
        $command_array = array(
            'command' => 'detachVolume',
            'id' => $id,
            'virtualmachineid' => $virtualMachineId,
            'deviceid' => $deviceId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function createVolume($name, $account = null, $diskOfferingId = null, $domainId = null, $size = null, $snapshotId = null, $zoneId = null)
    {
        $command_array = array(
            'command' => 'createVolume',
            'name' => $name,
            'account' => $account,
            'diskofferingid' => $diskOfferingId, //the ID of the disk offering. Either diskOfferingId or snapshotId must be passed in.
            'domainid' => $domainId,
            'size' => $size, //Arbitrary volume size. Mutually exclusive with diskOfferingId
            'snapshotid' => $snapshotId,
            'zoneid' => $zoneId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function deleteVolume($id)
    {
        $command_array = array(
            'command' => 'deleteVolume',
            'id' => $id,
            'response' => $this->responseType
        );
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    /******** End Disk Related Methods *********/
    /******** Start NAT Methods *********/
    
    public function enableStaticNat($virtualMachineId, $ipAddressId)
    {
        $command_array = array(
            'command' => 'enableStaticNat',
            'virtualmachineid' => $virtualMachineId,
            'ipaddressid' => $ipAddressId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function disableStaticNat($ipAddressId)
    {
        $command_array = array(
            'command' => 'disableStaticNat',
            'ipaddressid' => $ipAddressId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function createIpForwardingRule($ipAddressId, $protocol, $startPort, $cidrList = null, $endport = null, $openFirewall = null)
    {
        $command_array = array(
            'command' => 'createIpForwardingRule',
            'ipaddressid' => $ipAddressId,
            'protocol' => $protocol,
            'startport' => $startPort,
            'cidrlist' => $cidrList,
            'endport' => $endPort,
            'openfirewall' => $openFirewall,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function deleteIpForwardingRule($id)
    {
        $command_array = array(
            'command' => 'deleteIpForwardingRule',
            'id' => $id, //id of the rule
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    
    public function listIpForwardingRules($account = null, $domainId = null, $id = null, $ipAddressId = null, $keyword = null, $page = null, $pagesize = null, $virtualMachineId = null)
    {
        $command_array = array(
            'command' => 'listIpForwardingRules',
            'account' => $account,
            'domainid' => $domainId,
            'id' => $id,
            'ipaddressid' => $ipAddressId,
            'keyword' => $keyword,
            'page' => $page,
            'pagesize' => $pagesize,
            'virtualmachineid' => $virtualmachineId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    /******** End NAT Methods *********/
    /******** Start Zone Methods *********/
    public function listZones($available = null, $domainId = null, $id = null, $keyword = null, $page = null, $pagesize = null)
    {
        $command_array = array(
            'command' => 'listZones',
            'available' => $available, //true if you want to retrieve all available Zones. False if you only want to return the Zones from which you have at least one VM. Default is false.
            'domainid' => $domainId,
            'id' => $id,
            'keyword' => $keyword,
            'page' => $page,
            'pagesize' => $pagesize,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    /******** End Zone Methods *********/
    /******** Start Misc. Methods *********/
    public function listHypervisors($zoneId = null)
    {
        $command_array = array(
            'command' => 'listHypervisors',
            'zone' => $zoneId, //the zone id for listing hypervisors.
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    public function listServiceOfferings($domainId = null, $id = null, $isSystem = null, $keyword = null, $name = null, $page = null, $pagesize = null, $systemVmType = null, $virtualMachineId = null)
    {
        $command_array = array(
            'command' => 'listServiceOfferings',
            'domainid' => $domainId,
            'id' => $id,
            'issystem' => $isSystem,
            'keyword' => $keyword,
            'name' => $name,
            'page' => $page,
            'pagesize' => $pagesize,
            'systemvmtype' => $systemVmType,
            'virtualmachineid' => $virtualMachineId,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    public function listDiskOfferings($domainId = null, $id = null, $keyword = null, $name = null, $page = null, $pagesize = null)
    {
        $command_array = array(
            'command' => 'listDiskOfferings',
            'domainid' => $domainId,
            'id' => $id,
            'keyword' => $keyword,
            'name' => $name,
            'page' => $page,
            'pagesize' => $pagesize,
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }
    public function listAccounts($zoneId = null)
    {
        $command_array = array(
            'command' => 'listHypervisors',
            'zone' => $zoneId, //the zone id for listing hypervisors.
            'response' => $this->responseType
        );
        //remove empty elements to prevent API error
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    /* Start Network Methods */
    
    public function listNetworkOfferings($availability = null, $displaytext = null, $forvpc = null, $guestiptype = null, $id = null, $isdefault = null, $istagged = null, $keyword = null, $name = null, $networkid = null, $page = null, $pagesize = null, $sourcenatsupported = null, $specifyipranges = null, $specifyvlan = null, $state = null, $supportedservices = null, $tags = null, $traffictype = null, $zoneid = null) {
        $command_array = array(
            'command' => 'listNetworkOfferings',
            'availability' => $availability,
            'displaytext' => $displaytext,
            'forvpc' => $forvpc,
            'guestiptype' => $guestiptype,
            'id' => $id,
            'isdefault' => $isdefault,
            'istagged' => $istagged,
            'keyword' => $keyword,
            'name' => $name,
            'networkid' => $networkid,
            'page' => $page,
            'pagesize' => $pagesize,
            'sourcenatsupported' => $sourcenatsupported,
            'specifyvlan' => $specifyvlan,
            'state' => $state,
            'supportedservices' => $supportedservices,
            'tags' => $tags,
            'traffictype' => $traffictype,
            'zoneid' => $zoneid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function createNetwork($displaytext, $name, $networkofferingid, $zoneid, $account = null, $acltype = null, $domainid = null, $endip = null, $endipv6 = null, $gateway = null, $ip6cidr = null, $ip6gateway = null, $netmask = null, $networkdomain = null, $physicalnetworkid = null, $projectid = null, $startip = null, $startipv6 = null, $subdomainaccess = null, $vlan = null, $vpcid = null) {
    	$command_array = array(
            'command' => 'createNetwork',
            'displaytext' => $displaytext,
            'name' => $name,
            'networkofferingid' => $networkofferingid,
            'zoneid' => $zoneid,
            'account' => $account,
            'acltype' => $acltype,
            'domainid' => $domainid,
            'endip' => $endip,
            'endipv6' => $endipv6,
            'gateway' => $gateway,
            'ip6cidr' => $ip6cidr,
            'ip6gateway' => $ip6gateway,
            'netmask' => $netmask,
            'networkdomain' => $networkdomain,
            'physicalnetworkid' => $physicalnetworkid,
            'projectid' => $projectid,
            'startip' => $startip,
            'startipv6' => $startipv6,
            'subdomainaccess' => $subdomainaccess,
            'vlan' => $vlan,
            'vpcid' => $vpcid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);    	
    }

    public function deleteNetwork($id) {
    	$command_array = array(
            'command' => 'deleteNetwork',
            'id' => $id,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function listNetworks($account = null, $acltype = null, $canusefordeploy = null, $domainid = null, $forvpc = null, $id = null, $isrecursive = null, $issystem = null, $keyword = null, $listall = null, $page = null, $pagesize = null, $physicalnetworkid = null, $projectid = null, $restartrequired = null, $specifyipranges = null, $supportedservices = null, $tags = null, $traffictype = null, $type = null, $vpcid = null, $zoneid = null) {
        $command_array = array(
            'command' => 'listNetworks',
            'account' => $account,
            'acltype' => $acltype,
            'canusefordeploy' => $canusefordeploy,
            'domainid' => $domainid,
            'forvpc' => $forvpc,
            'id' => $id,
            'isrecursive' => $isrecursive,
            'issystem' => $issystem,
            'keyword' => $keyword,
            'listall' => $listall,
            'page' => $page,
            'pagesize' => $pagesize,
            'physicalnetworkid' => $physicalnetworkid,
            'projectid' => $projectid,
            'restartrequired' => $restartrequired,
            'specifyipranges' => $specifyipranges,
            'supportedservices' => $supportedservices,
            'tags' => $tags,
            'traffictype' => $traffictype,
            'type' => $type,
            'vpcid' => $vpcid,
            'zoneid' => $zoneid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function restartNetwork($id, $cleanup = null) {
    	$command_array = array(
            'command' => 'restartNetwork',
            'id' => $id,
            'cleanup' => $cleanup,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function updateNetwork($id, $changecidr = null, $displaytext = null, $name = null, $networkdomain = null, $networkofferingid = null) {
    	$command_array = array(
            'command' => 'updateNetwork',
            'id' => $id,
            'changecidr' => $changecidr,
            'displaytext' => $displaytext,
            'name' => $name,
            'networkdomain' => $networkdomain,
            'networkofferingid' => $networkofferingid,
            'cleanup' => $cleanup,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);    	
    }

    public function createNetworkACL($networkid, $protocol, $cidrlist = null, $endport = null, $icmpcode = null, $icmptype = null, $startport = null, $traffictype = null) {
    	$command_array = array(
            'command' => 'createNetworkACL',
            'networkid' => $networkid,
            'protocol' => $protocol,
            'cidrlist' => $cidrlist,
            'endport' => $endport,
            'icmpcode' => $icmpcode,
            'icmptype' => $icmptype,
            'startport' => $startport,
            'traffictype' => $traffictype,
            'cleanup' => $cleanup,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function deleteNetworkACL($id) {
    	$command_array = array(
            'command' => 'deleteNetworkACL',
            'id' => $id,
            'cleanup' => $cleanup,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function listNetworkACLs($account = null, $domainid = null, $id = null, $isrecursive = null, $keyword = null, $listall = null, $networkid = null, $page = null, $pagesize = null, $projectid = null, $tags = null, $traffictype = null) {
    	$command_array = array(
            'command' => 'listNetworkACLs',
            'account' => $account,
            'domainid' => $domainid,
            'id' => $id,
            'isrecursive' => $isrecursive,
            'keyword' => $keyword,
            'listall' => $listall,
            'networkíd' => $networkid,
            'page' => $page,
            'pagesize' => $pagesize,
            'projectid' => $projectid,
            'tags' => $tags,
            'traffictype' => $traffictype,
            'cleanup' => $cleanup,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    /* End Network Methods */

    /* Start Group Methods */

    public function createInstanceGroup($name, $account = null, $domainid = null, $projectid = null) {
		$command_array = array(
            'command' => 'createInstanceGroup',
            'name' => $name,
            'account' => $account,
            'domainid' => $domainid,
            'projectid' => $projectid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);    	
    }

    public function deleteInstanceGroup($id) {
    	$command_array = array(
            'command' => 'deleteInstanceGroup',
            'id' => $id,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function updateInstanceGroup($id, $name = null) {
    	$command_array = array(
            'command' => 'updateInstanceGroup',
            'id' => $id,
            'name' => $name,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    public function listInstanceGroups($account = null, $domainid = null, $id = null, $isrecursive = null, $keyword = null, $listall = null, $name = null, $page = null, $pagesize = null, $projectid = null) {
    	$command_array = array(
            'command' => 'listInstanceGroups',
            'account' => $account,
            'domainid' => $domainid,
            'id' => $id,
            'isrecursive' => $isrecursive,
            'keyword' => $keyword,
            'listall' => $listall,
            'name' => $name,
            'page' => $page,
            'pagesize' => $pagesize,
            'projectid' => $projectid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
    }

    /* End Group Methods */

    /* Start SSH Methods */

	public function createSSHKeyPair($name, $account = null, $domainid = null, $projectid = null) {
		$command_array = array(
            'command' => 'createSSHKeyPair',
            'name' => $name,
            'account' => $account,
            'domainid' => $domainid,
            'projectid' => $projectid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
	}

	public function deleteSSHKeyPair($name, $account = null, $domainid = null, $projectid = null) {
		$command_array = array(
            'command' => 'deleteSSHKeyPair',
            'name' => $name,
            'account' => $account,
            'domainid' => $domainid,
            'projectid' => $projectid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
	}

	public function listSSHKeyPairs($account = null, $domainid = null, $fingerprint = null, $isrecursive = null, $keyword = null, $listall = null, $name = null, $page = null, $pagesize = null, $projectid = null) {
		$command_array = array(
            'command' => 'deleteSSHKeyPair',
            'account' => $account,
            'domainid' => $domainid,
            'fingerprint' => $fingerprint,
            'isrecursive' => $isrecursive,
            'keyword' => $keyword,
            'listall' => $listall,
            'name' => $name,
            'page' => $page,
            'pagesize' => $pagesize,
            'projectid' => $projectid,
            'response' => $this->responseType
            );
        $command_array = array_filter($command_array);
        $command       = $this->_handleArray($command_array);
        return $this->_apiRequest($command);
	}

	/* End SSH Methods */
    
    protected function _signRequest($apiRequest)
    {
        $hashUrl       = 'apikey=' . strtolower($this->_apiKey) . '&' . strtolower($apiRequest);
        $hashedRequest = rawurlencode(base64_encode(hash_hmac('sha1', $hashUrl, $this->_secretKey, TRUE)));
        $apiRequest    = $this->_targetApi . '?' . $apiRequest . '&apikey=' . $this->_apiKey . '&signature=' . $hashedRequest;
        
        return $apiRequest;
    }
    
    protected function _apiRequest($request)
    {
        $request = $this->_signRequest($request);
        
        if ($this->_curlEnabled == 0) {
            return '<p>Return: <b>cURL is not enabled;</b> Here is your signed request for testing via browser or other method: <br /><small><a href="' . $request . '">' . $request . '</a></small></p>';
        } elseif ($this->return_signed_only == true) {
			return $request;
		}else {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $request);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSLVERSION, 3);
			curl_setopt($curl, CURLOPT_TIMEOUT,   10);
            $response = curl_exec($curl);
            
            if (curl_errno($curl)) {
                $curl_error = curl_error($curl);
            }
            curl_close($curl);
            
            if (!empty($curl_error)) {
                throw new Exception('Error communicating with API, CURL error ' . $curl_error);
            } else {
                if ($this->responseType == 'json') {
                    $response = $this->_indent($response);
                } else {
                    $response = $response;
                }
                return json_decode($response);
            }
        }
    }
    
    protected function _parseXmlResponse($response)
    {
        $xml  = simplexml_load_string($response);
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }
    
    protected function _handleArray($array)
    {
        if (!is_array($array)) {
            throw new exception('Variable passed is not an array');
            return null;
        }
        if (!array_key_exists('command', $array)) {
            throw new exception('Command not detected in array');
            return null;
        }
        ksort($array);
        $i = 1;
        foreach ($array as $key => $val) {
            if ($i <= 1) {
                $string = $key . '=' . rawurlencode($val);
                $i++;
            } else {
                $string .= '&' . $key . '=' . rawurlencode($val);
            }
        }
        return $string;
    }
    /**
     * Indents a flat JSON string to make it more human-readable
     *
     * @param string $json The original JSON string to process
     * @return string Indented version of the original JSON string
     */
    protected function _indent($json)
    {
        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = ' ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;
        
        for ($i = 0; $i <= $strLen; $i++) {
            // Grab the next character in the string
            $char = substr($json, $i, 1);
            
            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;
            }
            // If this character is the end of an element,
            // output a new line and indent the next line
            else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
            // Add the character to the result string
            $result .= $char;
            
            // If the last character was the beginning of an element,
            // output a new line and indent the next line
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos++;
                }
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
            $prevChar = $char;
        }
        
        return $result;
    }
    
    protected function _checkCurl()
    {
        if (function_exists('curl_init')) {
            return true;
        } else {
            return false;
        }
    }
    
}

function listCloudStackMethods()
{
    $class_methods = get_class_methods('cloudstack');
    
    foreach ($class_methods as $method_name) {
        if ($method_name != '__construct') {
            echo $method_name . '<br />';
        }
    }
}