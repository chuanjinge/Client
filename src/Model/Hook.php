<?php

declare(strict_types=1);

namespace Gitlab\Model;

use Gitlab\Client;

/**
 * @property int    $id
 * @property string $url
 * @property string $created_at
 */
final class Hook extends AbstractModel
{
    /**
     * @var string[]
     */
    protected static $properties = [
        'id',
        'url',
        'created_at',
    ];

    /**
     * @param Client $client
     * @param array  $data
     *
     * @return Hook
     */
    public static function fromArray(Client $client, array $data)
    {
        $hook = new self($data['id'], $client);

        return $hook->hydrate($data);
    }

    /**
     * @param Client $client
     * @param string $url
     *
     * @return Hook
     */
    public static function create(Client $client, string $url)
    {
        $data = $client->systemHooks()->create($url);

        return self::fromArray($client, $data);
    }

    /**
     * @param int         $id
     * @param Client|null $client
     *
     * @return void
     */
    public function __construct(int $id, Client $client = null)
    {
        $this->setClient($client);
        $this->setData('id', $id);
    }

    /**
     * @return bool
     */
    public function test()
    {
        $this->client->systemHooks()->test($this->id);

        return true;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $this->client->systemHooks()->remove($this->id);

        return true;
    }
}
