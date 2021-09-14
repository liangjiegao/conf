<?php


namespace Yiyu\Conf;

use App\Models\Conf;
use Superl\Permission\Service;
use Superl\Permission\UtilsClass;
use Illuminate\Support\Facades\Log;

class ConfService extends Service
{

    public function getOne(string $key)
    {
        $conf = Conf::query() -> where(['conf_key' => $key, 'comp_key' => $this->compKey]) -> first(['conf_key as key', 'content', 'type']);

        if (empty($conf)){
            $this->_code = CodeConf::CONF_NOT_EXIST;
            return false;
        }
        $conf->content = json_decode($conf->content, true);
        $conf = $conf -> toArray();

        return $conf;
    }

    public function getList(array $search)
    {
        $query = Conf::query() -> where(['comp_key' => $this->compKey]);

        if (!empty($search['type'])){
            $query->where(['type' => $search['type']]);
        }
        if (!empty($search['keyword'])){
            $query->where('content', 'like', "%{$search['keyword']}%");
        }
        if (!empty($search['unit'])){
            $query->whereRaw("JSON_EXTRACT(conf.content, '$.unit') = ?", [$search['unit']]);
        }
        if (!empty($search['keys'])){
            $query->whereIn('conf_key', $search['keys']);
        }

        $list = $query  -> orderByDesc('created_at')
                        -> get(['conf_key as key', 'content', 'type'])
                        -> toArray();

        for ($i = 0; $i < count($list); $i++){
            $list[$i]['content'] = json_decode($list[$i]['content'], true);
        }

        return $list;
    }

    public function addOne(array $data)
    {
        $return = ['key' => null];

        $confKey = $data['key'];

        // 添加
        if (empty($confKey)){
            $conf = new Conf();
            $conf->conf_key = $this->buildKey('conf');
            $conf->user_key = $this->userKey;
            $conf->comp_key = $this->compKey;
            $conf->type = $data['type'];
        }
        // 修改
        else{
            $conf = Conf::query() -> where(['conf_key' => $confKey]) -> first();
            if (empty($conf)){
                $this->_code = CodeConf::CONF_NOT_EXIST;
                return $return;
            }
        }

        if (!is_null($data['content'])){
            $conf->content = json_encode($data['content']);
        }

        $re = $conf->save();
        if ($re === false){
            $this->_code = CodeConf::MYSQL_WRITE_FAIL;
            return $return;
        }

        $return['key'] = $conf->conf_key;

        return $return;
    }

    public function delOne(string $key)
    {
        $conf = Conf::query()
            -> where(['conf_key' => $key, 'comp_key' => $this->compKey])
            -> first();

        if (empty($conf)){
            $this->_code = CodeConf::CONF_NOT_EXIST;
            return false;
        }

        try {
            $re = $conf->delete();
            if ($re === false){
                $this->_code = CodeConf::MYSQL_WRITE_FAIL;
            }
        } catch (\Exception $e) {
            UtilsClass::log("删除配置失败，异常信息：" . $e->getMessage(), 'exception');
            $this->_code = CodeConf::EXCEPTION;
        }

        return false;
    }

    public function delBatch(array $keys)
    {


    }

    // 映射配置到列表中（整个content）
    public function mapConf(array $list, array $cols){
        $keys = [];
        foreach ($cols as $col) {
            $keys = array_merge($keys, array_column($list, $col));
        }
        $confList = Conf::query()
            -> where(['comp_key' => $this->compKey])
            -> whereIn('conf_key', $keys)
            -> get(['conf_key as key', 'content', 'type'])
            -> toArray();

        for ($i = 0; $i < count($confList); $i++){
            $confList[$i]['content'] = json_decode($confList[$i]['content'], true);
        }
        for($i = 0; $i < count($list); $i++){
            foreach ($cols as $col) {
//                $list[$i][$col] = [];
                foreach ($confList as $conf) {
                    if ($list[$i][$col] === $conf['key']){
                        $list[$i][$col] = $conf;
                        break;
                    }
                }
            }
        }
        return $list;
    }

    // 映射配置到列表中（映射到具体属性）
    public function mapConfCol(array $list, array $cols)
    {
        $keys = [];
        foreach ($cols as $key => $col) {
            $keys = array_merge($keys, array_column($list, $key));
        }

        // 本地获取
        $confList = Conf::query()
            ->where(['comp_id' => $this->comp_id])
            ->whereIn('conf_key', $keys)
            ->get(['conf_key as key', 'content', 'type'])
            ->toArray();

        for ($i = 0; $i < count($confList); $i++) {
            $confList[$i]['content'] = json_decode($confList[$i]['content'], true);
        }
        for ($i = 0; $i < count($list); $i++) {
            foreach ($cols as $key => $col) {
                foreach ($col as $cK => $cV) {
                    $list[$i][$cK] = null;
                    foreach ($confList as $conf) {
                        if ($list[$i][$key] === $conf['key']) {
                            $list[$i][$cK] = $conf['content'][$cV] ?? '';
                            break;
                        }
                    }
                }
            }
        }
        return $list;
    }


    public function mapContacts(array $list){
        $contacts = [];
        for($i = 0; $i < count($list); $i++) {
            if (!empty($list[$i]['contacts'])){
                $contacts = array_merge($contacts, $list[$i]['contacts']);
            }
        }

        $confService = $this->getSingleServiceInstance(ConfService::class);
        $search = [
            'key' => $contacts
        ];
        $confList = $confService->getList($search);

        for($i = 0; $i < count($list); $i++) {
            $iContacts = $list[$i]['contacts'];
            $list[$i]['contacts'] = [];
            if (empty($iContacts)){
                continue;
            }
            foreach ($confList as $item) {
                if (in_array($item['key'], $iContacts)){
                    $list[$i]['contacts'][] = $item;
                }
            }
        }
        return $list;
    }

}
