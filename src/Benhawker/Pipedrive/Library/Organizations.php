<?php namespace Benhawker\Pipedrive\Library;

use Benhawker\Pipedrive\Exceptions\PipedriveMissingFieldError;

/**
 * Pipedrive Organizations Methods
 *
 * Organizations are companies and other kinds of organizations you are making 
 * Deals with. Persons can be associated with organizations so that each 
 * organization can contain one or more Persons.
 *
 */
class Organizations
{
    /**
     * Hold the pipedrive cURL session
     * @var Curl Object
     */
    protected $curl;
    
    /**
     * Initialise the object load master class
     */
    public function __construct(\Benhawker\Pipedrive\Pipedrive $master)
    {
        //associate curl class
        $this->curl = $master->curl();
    }

    /**
     * Returns a organization
     *
     * @param  int   $id pipedrive organizations id
     * @return array returns detials of a organization
     */
    public function getById($id)
    {
        return $this->curl->get('organizations/' . $id);
    }

	/**
     * Returns an organization
     *
     * @param  string $name pipedrive organizations name
     * @param  array  $data (start, limit)
     * @return array  returns detials of a organization
     */
    public function getByName($name, array $data = array())
    {
        $data['term'] = $name;
        return $this->curl->get('organizations/find', $data);
    }
    
      
    /**
     * Returns all organizations
     *
     * @param  array $data (filter_id, start, limit, sort_by, sort_mode)
     * @return array returns detials of all organizations
     */
    public function getAll(array $data = array())
    {
        return $this->curl->get('organizations/', $data);
    }

    /**
     * Lists deals associated with a organization.
     *
     * @param  array $data (id, start, limit)
     * @return array deals
     * @throws PipedriveMissingFieldError
     */
    public function deals(array $data)
    {
        //if there is no name set throw error as it is a required field
        if (!isset($data['id'])) {
            throw new PipedriveMissingFieldError('You must include the "id" of the organization when getting deals');
        }
        return $this->curl->get('organizations/' . $data['id'] . '/deals', $data);
    }

    /**
     * Updates an organization
     *
     * @param  int   $organizationId pipedrives organization Id
     * @param  array $data     new details of organization
     * @return array returns details of a organization
     */
    public function update($organizationId, array $data = array())
    {
        return $this->curl->put('organizations/' . $organizationId, $data);
    }

    /**
     * Adds a organization
     *
     * @param  array $data organizations details
     * @return array returns details of a organization
     * @throws PipedriveMissingFieldError
     */
    public function add(array $data)
    {
        //if there is no name set throw error as it is a required field
        if (!isset($data['name'])) {
            throw new PipedriveMissingFieldError('You must include a "name" field when inserting a organization');
        }

        return $this->curl->post('organizations', $data);
    }

    /**
     * Deletes an organization
     *
     * @param  int   $organizationId pipedrives organization Id
     * @return array returns details of a organization
     */
    public function delete($organizationId)
    {
        return $this->curl->delete('organizations/' . $organizationId);
    }

    /**
     * Bulk delete organizations
     *
     * @param $ids
     * @return array
     */
    public function bulkDelete($ids)
    {
        return $this->curl->bulkDelete('organizations', array('ids' => $ids));
    }


    /**
     * Get persons of organization
     *
     * @param $organizationId
     * @return array
     */

    public function listPersons($organizationId)
    {
        return $this->curl->get('organizations/'.$organizationId.'/persons');
    }

    /**
     * @param $organizationId
     * @return array
     */
    public function listFollowers($organizationId)
    {
        return $this->curl->get('organizations/' . $organizationId . '/followers');
    }

    /**
     * Add follower to organization.
     * @param $organizationId
     * @param $userId
     * @return array
     */
    public function addFollower($organizationId, $userId)
    {
        return $this->curl->post('organizations/' . $organizationId . '/followers',[
            'id' => $organizationId,
            'user_id' => $userId
        ]);
    }

    /**
     * Delete organization follower.
     * @param $organizationId
     * @param $userId
     * @return array
     */
    public function deleteFollower($organizationId, $userId)
    {
        return $this->curl->delete('organizations/' . $organizationId . '/followers/' . $userId);
    }

    /**
     * @param array $params
     * @return array
     */
    public function summary($params = [])
    {
        return $this->curl->get('organizations/summary', $params);
    }

    /**
     * List activities associated with organization
     * @param $organizationId
     * @param array $data
     * @return array
     */
    public function listActivities($organizationId, array $data = [])
    {
        return $this->curl->get('organizations/' . $organizationId . '/activities', $data);
    }
}
