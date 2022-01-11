<?php

namespace Chinkiver\TencentCos;

use Qcloud\Cos\Client;

class CosClient
{
    protected string $secret_id;
    protected string $secret_key;
    protected string $region;

    // 对象键
    protected string $app_id;

    // 存储桶名称 格式：BucketName-APPID
    protected string $bucket;

    // 协议头部，默认为 http
    protected string $schema;

    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * 获取客户端对象
     * @return Client
     */
    public function getClient(): Client
    {
        $secret_id = $this->secret_id;
        $secret_key = $this->secret_key;
        $region = $this->region;

        return new Client([
            'region' => $region,
            'schema' => $this->schema,
            'credentials' => [
                'secretId' => $secret_id,
                'secretKey' => $secret_key]]);
    }

    public function putObject($file)
    {
        try {
            $bucket = $this->bucket;
            $appId = $this->app_id;

            if ($file) {
                $result = $this->getClient()->putObject([
                    'Bucket' => $bucket,
                    'Key' => $appId,
                    'Body' => $file]);
                print_r($result);
            }
        } catch (\Exception $e) {
            echo "$e\n";
        }
    }
}
