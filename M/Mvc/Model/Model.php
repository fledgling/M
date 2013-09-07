<?php
/**
 * @link https://github.com/MaGuowei/M
 * @copyright 2013 maguowei.com
 * @author Ma Guowei <imaguowei@gmail.com>
 */
namespace M\Mvc\Model;

use M\M;
use M\Db\Db;
use M\Form\Form;

/**
 * 模型类
 *
 * Class Model
 * @package M\Mvc\Model
 */
class Model extends AbstractModel
{
    /**
     * 数据库连接实例
     * @var
     */
    private static $db;
    /**
     * 最近执行的的sql语句
     * @var
     */
    protected $sql;
    /**
     * 数据库表的主键
     * @var
     */
    protected $key;
    /**
     * 数据映射数组
     *
     * 负责映射模型属性名到数据库表的字段名
     * @var
     */
    protected $data;
    /**
     * 置顶要查询的字段范围，默认是所有列: ‘*’
     * @var
     */
    protected $cols = '*';
    /**
     * sql查询条件 WHERE 子句
     * @var
     */
    protected $where;
    /**
     * sql查询条件 ORDER BY 子句
     * @var
     */
    protected $orderBy;
    /**
     * sql查询条件 LIMIT 子句
     * @var
     */
    protected $limit;

    /**
     *初始化
     *
     * 建立数据库连接（单例模型）
     */
    public function init()
    {
        SqlBuilder::init($this);
        if(empty(self::$db))
        {
            $db = M::getConfig('db');
            self::$db = new Db($db['dsn'],$db['user'],$db['password']);
        }
        else
        {
            return self::$db;
        }
    }

    /**
     * 置顶查询的范围，选定需要查询的数据库表的字段
     *
     * @param $cols
     */
    public function cols($cols)
    {
        $this->cols = $cols;
    }

    /**
     * @param $where
     * @return $this
     */
    public function where($where)
    {
        $this->where = " WHERE $where";
        return $this;
    }

    /**
     * 指定查询返回结果的顺序
     *
     * ORDER BY
     *
     * @param $by
     * @param string $order
     * @return $this
     */
    public function orderBy($by,$order='desc')
    {
        $this->orderBy = " ORDER BY $by $order";
        return $this;
    }

    /**
     * @param $number
     * @param null $number2
     * @return $this
     */
    public function limit($number,$number2=null)
    {
        if(isset($number2))
        {
            $this->limit = " LIMIT $number,$number2";
        }
        else
        {
            $this->limit = " LIMIT $number";
        }
        return $this;
    }

    /**
     * @param string $cols 要查询的列，默认为所有列
     * @return mixed
     */
    public function select($cols = '*')
    {
        $this->cols = $cols;
        $this->sql = SqlBuilder::selectSqlBuild();
        $result = self::$db->select($this->sql);
        return $result;
    }

    /**
     * @param $key
     * @param string $value
     * @return mixed
     */
    public function find($key,$value='')
    {
        $this->sql = SqlBuilder::findSqlBuild($key,$value);
        $result = self::$db->find($this->sql);
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $this->sql = SqlBuilder::findByIdSqlBuild($id);
        $result = self::$db->find($this->sql);
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $this->sql = SqlBuilder::deleteSqlBuild($id);
        $result = self::$db->delete($this->sql);
        return $result;
    }

    /**
     * @return mixed
     */
    public function add()
    {
        $this->sql = SqlBuilder::addSqlBuild();
        $result = self::$db->insert($this->sql);
        return $result;
    }

    /**
     * 保存记录
     *
     * 根据是$key值是否为空选择插入或者更新
     */
    public function save()
    {
        if(empty($this->id))
        {
            return $this->add();
        }
        else
        {
            return $this->update();
        }
    }

    /**
     * 更新记录
     *
     * @return mixed
     */
    public function update()
    {
        $this->sql = SqlBuilder::updateSqlBuild();
        $result = self::$db->update($this->sql);
        return $result;
    }

    /**
     * 执行原始sql语句
     * @param $sql
     * @return mixed
     */
    public function exec($sql)
    {
        $result = self::$db->exec($sql);
        return $result;
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function query($sql)
    {
        $result = self::$db->query($sql);
        return $result;
    }

    /**
     * 获取POST提交的数据
     *
     * 自动将POST方式提交的数据赋值到模型属性
     */
    public function get_Post()
    {
        Form::postToModel($this);
    }

    /**
     * 获取PDO对象
     *
     * @return mixed
     */
    public function getPdo()
    {
        return self::$db->getPdo();
    }

    /**
     * 返回最近执行的sql语句
     *
     * @param bool $show
     * @return mixed
     */
    public function getSql($show=false)
    {
        if($show)
        {
            echo $this->sql;
        }
        else
        {
            return $this->sql;
        }
    }
}