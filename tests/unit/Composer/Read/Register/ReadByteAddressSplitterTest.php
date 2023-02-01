<?php

namespace Tests\unit\Composer\Read\Register;


use ModbusTcpClient\Composer\AddressSplitter;
use ModbusTcpClient\Composer\Read\Coil\ReadCoilAddress;
use ModbusTcpClient\Composer\Read\Coil\ReadCoilAddressSplitter;
use ModbusTcpClient\Composer\Read\ReadRegistersBuilder;
use ModbusTcpClient\Composer\Read\Register\ByteReadRegisterAddress;
use ModbusTcpClient\Composer\Read\Register\ReadRegisterAddressSplitter;
use ModbusTcpClient\Packet\ModbusFunction\ReadCoilsRequest;
use ModbusTcpClient\Packet\ModbusFunction\ReadInputRegistersRequest;
use PHPUnit\Framework\TestCase;

class ReadByteAddressSplitterTest extends TestCase
{
    public function testSplitSameAddress()
    {

        $splitter = new ReadRegisterAddressSplitter(ByteReadRegisterAddress::class);
        $requests = $splitter->split([
            'tcp://127.0.0.1' . AddressSplitter::UNIT_ID_PREFIX . '1' => [
                new ByteReadRegisterAddress(1,false),
                new ByteReadRegisterAddress(1, true),
            ]
        ]);
        $this->assertCount(1, $requests);
        $this->assertCount(2, $requests[0]->getAddresses());
        $addreses = $requests[0]->getAddresses();
        $this->assertTrue($addreses[0]->isFirstByte());
    }
}
