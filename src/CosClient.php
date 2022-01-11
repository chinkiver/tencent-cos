<?php

namespace Chinkiver\TencentCos;

use Qcloud\Cos\Client;

class CosClient
{
    protected string $secretId;
    protected string $secretKey;
    protected string $region;

    // 对象键
    protected string $appId;

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
        $secretId = $this->secretId;
        $secretKey = $this->secretKey;
        $region = $this->region;

        return new Client([
            'region' => $region,
            'schema' => $this->schema,
            'credentials' => [
                'secretId' => $secretId,
                'secretKey' => $secretKey]]);
    }

    public function putObject($file)
    {
        try {
            $bucket = $this->bucket;
            $key = $this->appId;

            if ($file) {
                $result = $this->getClient()->putObject([
                    'Bucket' => $bucket,
                    'Key' => $key,
                    'Body' => $file]);
                print_r($result);
            }
        } catch (\Exception $e) {
            echo "$e\n";
        }
    }
}
